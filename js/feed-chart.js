// FeedChart class
// Variables needed: window.apikey_read, window.emoncms_path
// Libraries needed: jQuery, flot, flot.touch, flot.time, flot.selection, date.format, chart-view, timeseries
//
// Parameters:
//   divId: id of the graph container
//   feeds: array of feed objects
//     id: id of the feed
//     color (optional): color of the feed
//     legend (optional): legend of the feed
//     line (optional): line width (from 0 to 1)
//     fill (optional): line fill (from 0 to 1)
//   options: object of configuration options
//     chartType: type of the graph ("instant"/"daily")
//     defaultRange: default interval for the visualization (in days)
//     pWidth: percentaje of screen width (from 0 to 1)
//     pHeight: percentaje of screen height (from 0 to 1)
//     updateinterval: time between updates in live mode (in ms)
//     selectable: chart can be selected and zoomed in (boolean)
function FeedChart(divId, feeds, options) {
  "use strict";

  // Parameter Properties
  // ID of the div where the graph is drawn
  this.divId = divId;
  // Options
  // Default interval drawn
  this.defaultRange = options.defaultRange;
  // Percentaje of the screen width
  this.pWidth = options.pWidth;
  // Percentaje of the screen height
  this.pHeight = options.pHeight;
  // Time between updates in live mode (in ms)
  this.updateinterval = options.updateinterval;
  // Type of chart
  this.chartType = options.chartType;
  // Chart can be selected and zoomed in
  this.selectable = options.selectable;
  // Feed ids, colors, legends, lines and fills
  this.feeds = [];
  this.feed_colors = [];
  this.feed_legends = [];
  this.feed_lines = [];
  this.feed_fills = [];
  for(var feedid in feeds) {
    var feed = feeds[feedid];
    this.feeds.push(feed.id);
    if (typeof feed.color !== "undefined") {
      this.feed_colors["f" + feed.id] = feed.color;
    } else {
      this.feed_colors["f" + feed.id] = null;
    }
    if (typeof feed.legend !== "undefined") {
      this.feed_legends["f" + feed.id] = feed.legend;
    } else {
      this.feed_legends["f" + feed.id] = null;
    }
    if (typeof feed.line !== "undefined") {
      this.feed_lines["f" + feed.id] = feed.line;
    } else {
      this.feed_lines["f" + feed.id] = 0.2;
    }
    if (typeof feed.fill !== "undefined") {
      this.feed_fills["f" + feed.id] = feed.fill;
    } else {
      this.feed_fills["f" + feed.id] = 0.7;
    }
  }

  // Object Properties
  // Live (setInterval)
  this.live = false;
  // Auto update
  this.autoupdate = true;
  // Reload the chart
  this.reload = true;
  // Last update
  this.lastupdate = 0;
  // View
  this.view = new ChartView();
  // Data store
  this.datastore = {};
  // Timeseries
  this.timeseries = new TimeSeries(this.datastore);

  // Instant graph (1 minute min range)
  if(this.chartType == "instant") {
    this.view.minimum_time_window = 60000;
  }
  // Daily graph (7 days min range)
  else if(this.chartType == "daily") {
    this.view.minimum_time_window = 60000 * 60 * 24 * 7;
  }
  // Set default range
  this.view.timewindow(this.defaultRange);

  // Placeholder bound
  this.placeholder_bound = $("#" + divId);
  // Placeholder
  this.placeholder_bound.append($("<div/>", {id: divId + "_plot"}));
  this.placeholder = $("#" + divId + "_plot");

  // Bind selection
  var self = this;
  if(this.selectable) {
    this.placeholder.bind("plotselected", function (event, ranges) {
      self.view.start = ranges.xaxis.from;
      self.view.end = ranges.xaxis.to;

      // Minimum window
      if((self.view.end - self.view.start) < self.view.minimum_time_window) {
        var time_window = self.view.minimum_time_window;
        var middle = (self.view.end + self.view.start) / 2;
        self.view.start = middle - time_window / 2;
        self.view.end = middle + time_window / 2;
      }

      self.autoupdate = false;
      self.reload = true;

      var now = +new Date();
      if (Math.abs(self.view.end - now) < 30000) {
        if(self.chartType == "instant") {
          self.autoupdate = false;
        }
      }

      self.draw();
    });
  }

  // Resize event
  $(window).resize(function() {
    self.resize();
    self.draw();
  });

  // Functions
  // Show graph
  this.show = function() {
    this.resize();
    if(this.chartType == "instant") {
      this.livefn();
      var self = this;
      this.live = setInterval(function() {
        self.livefn();
      }, this.updateinterval);
    }
    this.draw();
  };

  // Resize graph
  this.resize = function() {
    this.placeholder_bound.width((this.pWidth * 100) + "%");
    var width = this.placeholder_bound.width();
    var height = $(window).height() * this.pHeight;

    if(height > width) {
      height = width;
    }

    this.placeholder.width(width);
    this.placeholder_bound.height(height);
    this.placeholder.height(height);
  };

  // Update graph
  this.livefn = function() {
    // Check if the updater ran in the last 60s
    //   If it did not the app was sleeping
    //   and so the data needs a full reload
    var now = +new Date();
    if((now - this.lastupdate) > 60000) {
      this.reload = true;
    }
    this.lastupdate = now;

    // If autoupdate active
    if(this.autoupdate) {
      // Declare feed here so if the for loop has only 1 iteration we keep the feed index
      var feed;
      // Requests array
      var requests = [];
      for(var feedid in this.feeds) {
        feed = this.feeds[feedid];
        // Let atleast have 11sec, since the data is pushed every 10 seconds
        requests.push(this.getData(feed, now - 1.5*this.updateinterval, now + 1000, 1, 0));
      }
      // Save context before jQuery calls
      var self = this;
      // When all requests finish
      $.when.apply($, requests).done(function() {
        // Special case if there is only one request
        if (requests.length == 1) {
          // Get only the data that is not null
          var filteredFeedData = [];
          $.map(arguments[0], function(eachFeedData) {
            if(eachFeedData[1] != null) {
              filteredFeedData.push(eachFeedData);
            }
          });
          // If any data to append, append it
          if(filteredFeedData.length >= 1) {
            var feedData = filteredFeedData.pop();
            self.timeseries.append("f" + feed, feedData[0], parseInt(feedData[1]));
            self.timeseries.trimstart("f" + feed, self.view.start * 0.001);
          }
        }
        // For each request
        else {
          $.each(arguments, function(index, responseData) {
            // Get only the data that is not null
            var filteredFeedData = [];
            $.map(responseData[0], function(eachFeedData) {
              if(eachFeedData[1] != null) {
                filteredFeedData.push(eachFeedData);
              }
            });
            // If any data to append, append it
            if(filteredFeedData.length >= 1) {
              var feedData = filteredFeedData.pop();
              self.timeseries.append("f" + feed, feedData[0], parseInt(feedData[1]));
              self.timeseries.trimstart("f" + feed, self.view.start * 0.001 + 10);
            }
          });
        }
        var timerange = self.view.end - self.view.start;
        self.view.end = now;
        self.view.start = self.view.end - timerange;
        // Draw
        self.draw();
      });
    } else {
      // Draw the graph
      this.draw();
    }
  };

  // Draw graph
  this.draw = function() {
    // If daily graph, draw a bar graph with a interval of 1 day
    if(this.chartType === "daily") {
      this.drawBargraph(60 * 60 * 24);
      return;
    }

    // Number of datapoints
    var npoints = 1500;
    var interval = Math.round(((this.view.end - this.view.start) / npoints) / 1000);
    if(interval < 1) {
      interval = 1;
    }
    npoints = parseInt((this.view.end - this.view.start) / (interval * 1000));

    // Load data on init or reload
    if(this.reload) {
      this.reload = false;
      this.view.start = 1000 * Math.floor((this.view.start / 1000) / interval) * interval;
      this.view.end = 1000 * Math.ceil((this.view.end / 1000) / interval) * interval;

      // Declare feed here so if the for loop has only 1 iteration we keep the feed index
      var feed;
      // Requests array
      var requests = [];
      for(var i in this.feeds) {
        feed = this.feeds[i];
        requests.push(this.getData(feed, this.view.start, this.view.end, interval, 0));
      }
      // Save context before jQuery calls
      var self = this;
      // When all requests finish
      $.when.apply($, requests).done(function() {
        // Special case if there is only one request
        if (requests.length == 1) {
          var feedData = arguments[0];
          // Fix single data exception
          if(feedData.length == 1) {
            feedData[1] = feedData[0];
          }
          self.timeseries.load("f" + feed, feedData);
        }
        // For each request
        else {
          $.each(arguments, function(index, responseData) {
            var feedData = responseData[0];
            var feedId = self.feeds[index];
            // Fix single data exception
            if(feedData.length == 1) {
              feedData[1] = feedData[0];
            }
            self.timeseries.load("f" + feedId, feedData);
          });
        }
        // Self call, now this.reload is false so it won't retrieve the data again
        self.draw();
      });
      return;
    }

    // No data yet (ajax calls in progress)
    if(Object.getOwnPropertyNames(this.datastore).length === 0) {
      return;
    }

    // flot options
    var options = {
      lines: {
        fill: false,
        steps: true
      },
      xaxis: {
        mode: "time",
        timezone: "browser",
        min: this.view.start,
        max: this.view.end,
        minTickSize: [1, "second"]
      },
      yaxes: [
        {
          min: 0
        }
      ],
      grid: {
        hoverable: this.selectable,
        clickable: this.selectable
      },
      selection: {
        mode: "x"
      },
      legend: {
        show: true,
        position: "nw",
        backgroundOpacity: 0.5,
      }
    };

    // Initialize plot data
    var plot_data = [];

    // Data start
    var datastart = this.view.start;
    for(var z in this.datastore) {
      datastart = Math.min(datastart, this.datastore[z].data[0][0]);
      npoints = Math.max(this.datastore[z].data.length);
    }

    // Push data
    for(var z = 0; z < npoints; z++) {
      for(var i in this.feeds) {
        var feed = this.feeds[i];
        if((this.datastore["f" + feed].data[z] != undefined) && (this.datastore["f" + feed].data[z][1] != null)) {
        // Append even null data if no fill option is wanted
        // if(this.datastore["f" + feed].data[z] != undefined) {
          if(plot_data["f" + feed] == undefined) {
            plot_data["f" + feed] = [];
          }
          plot_data["f" + feed].push([this.datastore["f" + feed].data[z][0], this.datastore["f" + feed].data[z][1]]);
        }
      }
    }

    // Axis options
    options.xaxis.min = datastart + this.updateinterval;
    options.xaxis.max = this.view.end - this.updateinterval;

    // Data for the plot
    var series = [];
    for(var i in plot_data) {
      var feed_data = plot_data[i];
      var seriesData = {
        data: feed_data,
        color: this.feed_colors[i],
        lines: {
          lineWidth: this.feed_lines[i],
          fill: this.feed_fills[i]
        },
        label: this.feed_legends[i]
      };
      series.push(seriesData);
    }

    // If no data retrieved, return
    if(series.length == 0) {
      return;
    }

    // Call flot
    $.plot(this.placeholder, series, options);
  };

  // Draw a bar graph
  this.drawBargraph = function() {
    // Get timezone offset in hours
    var now = +new Date();
    var offset = ((new Date()).getTimezoneOffset()) / (-60);
    var intervalms = 60 * 60 * 24 * 1000;

    // Data adjustment required
    if(((this.view.start + offset * 3600000) % intervalms) != 0) {
      var datastart = Math.floor(this.view.start / intervalms) * intervalms;

      // Minus one and a half day if you don't want to plot the day in progress
      // var dataend = Math.ceil(this.view.end / intervalms) * intervalms - 60*60*36*1000;
      // Minus half a day if you don't want to plot the next day
      var dataend = Math.ceil(this.view.end / intervalms) * intervalms - 60*60*12*1000;

      // Start of the day (date - offset in hours)
      datastart -= offset * 3600000;
      dataend -= offset * 3600000;
      this.view.start = datastart;
      this.view.end = dataend;
    }

    // Get data
    // Plot data
    var plot_data = [];
    // Declare feed here so if the for loop has only 1 iteration we keep the feed index
    var feed;
    // Requests array
    var requests = [];
    for(var i in this.feeds) {
      feed = this.feeds[i];
      requests.push(this.getData(feed, this.view.start, this.view.end, 60 * 60 * 24, 1));
    }
    // Save context before jQuery calls
    var self = this;
    // When all requests finish
    $.when.apply($, requests).done(function() {
      // Special case if there is only one request
      if (requests.length == 1) {
        var feedData = arguments[0];
        plot_data["f" + feed] = [];
        for(var z = 0; z < feedData.length; z++) {
          // Do not plot null or future data
          if((feedData[z][1] != null) && (feedData[z][0] <= now)) {
            plot_data["f" + feed].push([feedData[z][0], feedData[z][1]]);
          }
        }
      }
      // For each request
      else {
        $.each(arguments, function(index, responseData) {
          var feedData = responseData[0];
          var feedId = self.feeds[index];
          plot_data["f" + feedId] = [];
          for(var z = 0; z < feedData.length; z++) {
            // Do not plot null or future data
            if((feedData[z][1] != null) && (feedData[z][0] <= now)) {
              plot_data["f" + feedId].push([feedData[z][0], feedData[z][1]]);
            }
          }
        });
      }

      // Plot data
      // Plot options
      var options = {
        bars: {
          show: true,
          align: "center",
          barWidth: 0.7 * 60 * 60 * 24 * 1000,
          fill: true
        },
        xaxis: {
          mode: "time",
          timezone: "browser",
          min: self.view.start,
          max: self.view.end,
          minTickSize: [1, "day"]
        },
        yaxes: [
          {
            min: 0
          }
        ],
        grid: {
          hoverable: self.selectable,
          clickable: self.selectable
        },
        selection: {
          mode: "x"
        },
        legend: {
          show: true,
          position: "nw",
          backgroundOpacity: 0.5,
        },
      };

      // Data for the plot
      var series = [];
      for(var i in plot_data) {
        var feed_data = plot_data[i];
        var seriesData = {
          data: feed_data,
          color: self.feed_colors[i],
          label: self.feed_legends[i]
        };
        series.push(seriesData);
      }

      // If no data retrieved, return
      if(series.length == 0) {
        return;
      }

      // Call flot
      $.plot(self.placeholder, series, options);
    });
  };

  // Get feed data (async)
  this.getData = function(id, start, end, interval, limitinterval) {
    return $.ajax({
      url: window.emoncms_path + "/feed/data.json?apikey=" + window.apikey_read,
      data: "id="+id+"&start="+start+"&end="+end+"&interval="+interval+"&skipmissing=0&limitinterval="+limitinterval,
      dataType: "json",
      success: function(data) {
        return data;
      }
    });
  };
};

//
// FeedChartFactory module
//   Creates FeedCharts with controls
(function (FeedChartFactory, $, undefined) {
  "use strict";

  // Creates a new FeedChart
  //
  // Parameters:
  //   divId: id of the graph container
  //   feeds: array of feed objects
  //     id: id of the feed
  //     color (optional): color of the feed
  //     legend (optional): legend of the feed
  //     line (optional): line width (from 0 to 1)
  //     fill (optional): line fill (from 0 to 1)
  //   options: object of configuration options
  //     chartType: chart type ("instant"/"daily")
  //     defaultRange: default interval for the visualization (in days)
  //     pWidth: percentaje of screen width (from 0 to 1)
  //     pHeight: percentaje of screen height (from 0 to 1)
  //     updateinterval: time between updates in live mode (in ms)
  //     selectable: chart can be selected and zoomed in (boolean)
  //     controls: append controls to the chart (boolean)
  FeedChartFactory.create = function (containerId, feeds, options) {
    // Default options
    var defaultOptions = {
      chartType: "instant",
      defaultRange: 7,
      pWidth: 1,
      pHeight: 0.5,
      updateinterval: 10000,
      selectable: true,
      controls: true
    };
    // Merge defaultOptions and options, without modifying defaultOptions
    var chartOptions = $.extend({}, defaultOptions, options);

    if(chartOptions.controls === true) {
      // Controlbar
      var controlbar = $("<div/>", {class: "fchartbar"});
      // Append the controlbar to the container
      $("#"+containerId).append(controlbar);
    }

    // Append the chart div to the container
    $("#"+containerId).append($("<div/>", {id: containerId + "_chart", class: "flinechart"}));
    // Chart
    var fchart = new FeedChart(containerId + "_chart", feeds, chartOptions);

    // Append controls
    if(chartOptions.controls === true) {
      // Chart controls
      if(chartOptions.chartType == "instant") {
        // 1h
        $("<span/>", {text: "1h", click: function() {
          fchart.view.timewindow(1/24.0);
          fchart.reload = true;
          fchart.autoupdate = true;
          fchart.draw();
        }}).appendTo(controlbar);
        // 8h
        $("<span/>", {text: "8h", click: function() {
          fchart.view.timewindow(8/24.0);
          fchart.reload = true;
          fchart.autoupdate = true;
          fchart.draw();
        }}).appendTo(controlbar);
        // D
        $("<span/>", {text: "D", click: function() {
          fchart.view.timewindow(1);
          fchart.reload = true;
          fchart.autoupdate = true;
          fchart.draw();
        }}).appendTo(controlbar);
      }
      // W
      $("<span/>", {text: "W", click: function() {
        fchart.view.timewindow(7);
        fchart.reload = true;
        fchart.autoupdate = true;
        fchart.draw();
      }}).appendTo(controlbar);
      // M
      $("<span/>", {text: "M", click: function() {
        fchart.view.timewindow(31);
        fchart.reload = true;
        if(chartOptions.chartTypefchart == "instant") {
          fchart.autoupdate = true;
        }
        fchart.draw();
      }}).appendTo(controlbar);
      // Y
      $("<span/>", {text: "Y", click: function() {
        fchart.view.timewindow(365);
        fchart.reload = true;
        if(chartOptions.chartTypefchart == "instant") {
          fchart.autoupdate = true;
        }
        fchart.draw();
      }}).appendTo(controlbar);
      // Zoom in
      $("<span/>", {text: "+", click: function() {
        fchart.view.zoomin();
        fchart.reload = true;
        if(chartOptions.chartTypefchart == "instant") {
          fchart.autoupdate = true;
        }
        fchart.draw();
      }}).appendTo(controlbar);
      // Zoom out
      $("<span/>", {text: "-", click: function() {
        fchart.view.zoomout();
        fchart.reload = true;
        if(chartOptions.chartTypefchart == "instant") {
          fchart.autoupdate = true;
        }
        fchart.draw();
      }}).appendTo(controlbar);
      // Pan left
      $("<span/>", {text: "<", click: function() {
        fchart.view.panleft();
        fchart.reload = true;
        if(chartOptions.chartTypefchart == "instant") {
          fchart.autoupdate = true;
        }
        fchart.draw();
      }}).appendTo(controlbar);
      // Pan right
      $("<span/>", {text: ">", click: function() {
        fchart.view.panright();
        fchart.reload = true;
        if(chartOptions.chartTypefchart == "instant") {
          fchart.autoupdate = true;
        }
        fchart.draw();
      }}).appendTo(controlbar);
    }

    // Show chart
    fchart.show();

    // Return chart
    return fchart;
  };
}(window.FeedChartFactory = window.FeedChartFactory || {}, jQuery));
