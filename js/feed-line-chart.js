// FeedLineChart class
// Variables needed: window.apikey_read, window.emoncms_path
// Libraries needed: jQuery, flot, flot.time, flot.selection, date.format, chart-view, timeseries
//
// Parameters:
//   divId: id of the graph container
//   feeds: list of feed ids
//   defaultRange: default interval for the visualization (in days)
function FeedLineChart(divId, feeds, defaultRange) {
  "use strict";

  // Parameter Properties
  // ID of the div where the graph is drawn
  this.divId = divId;
  // Array of feed id's to be represented
  this.feeds = feeds;
  // Default interval drawn
  this.defaultRange = defaultRange;

  // Object Properties
  // Live (setInterval)
  this.live = false;
  // Reload the chart
  this.reload = true;
  // Autoupdate the cart
  this.autoupdate = true;
  // Last update
  this.lastupdate = 0;
  // View
  this.view = new ChartView();
  this.view.timewindow(defaultRange);
  // Data store
  this.datastore = {};
  // Timeseries
  this.timeseries = new TimeSeries(this.datastore);

  // Set default range
  this.view.timewindow(defaultRange);

  // Placeholder bound
  this.placeholder_bound = $("#" + divId);
  // Placeholder
  this.placeholder_bound.append($("<div/>", {id: divId + "_plot"}));
  this.placeholder = $("#" + divId + "_plot");

  // Bind selection
  this.placeholder.bind("plotselected", function (event, ranges) {
    this.view.start = ranges.xaxis.from;
    this.view.end = ranges.xaxis.to;

    this.autoupdate = false;
    this.reload = true;

    var now = +new Date();
    if (Math.abs(view.end-now)<30000) {
      this.autoupdate = true;
    }

    this.draw();
  });

  // Resize event
  var thisChart = this;
  $(window).resize(function() {
    thisChart.resize();
    thisChart.draw();
  });

  // Functions
  // Show graph
  this.show = function() {
    this.livefn();
    this.live = setInterval(this.livefn, 10000);
    this.resize();
    this.draw();
  };

  // Resize graph
  this.resize = function() {
    var width = this.placeholder_bound.width();
    var height = $(window).height() * 0.5;

    if(height > width) {
      height = width;
    }

    this.placeholder.width(width);
    this.placeholder_bound.height(height);
    this.placeholder.height(height);
  };

  // Hide graph
  this.hide = function() {
    clearInterval(this.live);
  };

  // Update graph
  this.livefn = function() {
    // TODO
  };

  // Draw graph
  this.draw = function() {
    // TODO
  };

  // Get feed last value
  this.getValue = function(id) {
    var value = 0;
    $.ajax({
      url: window.emoncms_path + "/feed/value.json?apikey=" + window.apikey_read,
      data: "id=" + id,
      async: false,
      success: function(value_in) {
        value = value_in;
      }
    });
    return value;
  };

  // Get feed data
  this.getData = function(id, start, end, interval) {
    var data = [];
    $.ajax({
      url: window.emoncms_path + "/feed/data.json?apikey=" + window.apikey_read,
      data: "id="+id+"&start="+start+"&end="+end+"&interval="+interval+"&skipmissing=0&limitinterval=0",
      dataType: "json",
      async: false,
      success: function(data_in) {
        data = data_in;
      }
    });
    return data;
  };
}

//
// FeedLineChartFactory module
//   Creates FeedLineCharts with controls
//
//   Parameters
//     container: id of the controls+graph container
//     feeds: list of feed ids
//     defaultRange: default interval for the visualization (in days)
(function (FeedLineChartFactory, $, undefined) {
  "use strict";
  // Add new FeedLineChart
  FeedLineChartFactory.create = function (containerId, feeds, defaultRange) {

    // Controlbar
    var controlbar = $("<div/>", {class: "fchartbar"});
    // Append the controlbar to the container
    $("#"+containerId).append(controlbar);

    // Append the chart div to the container
    $("#"+containerId).append($("<div/>", {id: containerId + "_chart", class: "flinechart"}));
    // Chart
    var fchart = new FeedLineChart(containerId + "_chart", feeds, defaultRange);

    // Chart controls
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
    // W
    $("<span/>", {text: "W", click: function() {
      fchart.view.timewindow(7);
      fchart.reload = true;
      fchart.autoupdate = true;
      fchart.draw();
    }}).appendTo(controlbar);
    // M
    $("<span/>", {text: "M", click: function() {
      fchart.view.timewindow(30);
      fchart.reload = true;
      fchart.autoupdate = true;
      fchart.draw();
    }}).appendTo(controlbar);
    // Y
    $("<span/>", {text: "Y", click: function() {
      fchart.view.timewindow(365);
      fchart.reload = true;
      fchart.autoupdate = true;
      fchart.draw();
    }}).appendTo(controlbar);
    // Zoom in
    $("<span/>", {text: "+", click: function() {
      fchart.view.zoomin();
      fchart.reload = true;
      fchart.autoupdate = false;
      fchart.draw();
    }}).appendTo(controlbar);
    // Zoom out
    $("<span/>", {text: "-", click: function() {
      fchart.view.zoomout();
      fchart.reload = true;
      fchart.autoupdate = false;
      fchart.draw();
    }}).appendTo(controlbar);
    // Pan left
    $("<span/>", {text: "<", click: function() {
      fchart.view.panleft();
      fchart.reload = true;
      fchart.autoupdate = false;
      fchart.draw();
    }}).appendTo(controlbar);
    // Pan right
    $("<span/>", {text: ">", click: function() {
      fchart.view.panright();
      fchart.reload = true;
      fchart.autoupdate = false;
      fchart.draw();
    }}).appendTo(controlbar);
  };
}(window.FeedLineChartFactory = window.FeedLineChartFactory || {}, jQuery));
