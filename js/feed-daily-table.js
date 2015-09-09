// FeedDailyTable class
// Variables needed: window.apikey_read, window.emoncms_path
// Libraries needed: jQuery, bootstrap-datetimepicker
//
// Parameters:
//   divId: id of the table container
//   startDateId: id of the start date input
//   endDateId: id of the end date input
//   feeds: array of feed objects
//     id: id of the feed
//     name: name of the feed
//   localization (optional): localization object
//     day: string for 'day'
//     nodata: string for no data on the table ('No data available at the selected date range')
//     exportcsv: string for the export to csv button ('Export to CSV') ("" to not show the button)
//     total: string for last row ('Total') ("" to not show the total)
function FeedDailyTable(divId, startDateId, endDateId, feeds, localization) {
  "use strict";

  // Default localization options
  var defaultLocalization = {
    day: "Day",
    nodata: "No data available at the selected date range",
    exportcsv: "Export to CSV",
    total: "Total"
  };

  // Parameter properties
  // Container id
  this.divId = divId;
  // Id of the start date of the daily table
  this.startDateId = startDateId;
  // Id of the end date of the daily table
  this.endDateId = endDateId;
  // Array of feeds with id and name
  this.feeds = feeds;
  // Localization
  this.localization = $.extend({}, defaultLocalization, localization);

  // Object properties
  // Container object
  this.div = $(divId);
  // Feed/col names
  this.feed_ids = [];
  this.col_names = [];
  for(var index in this.feeds) {
    this.feed_ids[this.feeds[index].name] = "f" + this.feeds[index].id;
    this.col_names[index] = this.feeds[index].name;
  }
  // Data array (["d" + date] => [["f" + feedid] => value])
  this.feedData = [];

  // Save context
  var self = this;

  // Build the table
  // Table container
  this.table = $("<div/>", {class: "daily-table"});
  this.div.append(this.table);
  if(this.localization.exportcsv != "") {
    // Export to CSV button
    this.button = $("<input/>", {
      class: "export-table-csv btn",
      name: "exportcsv",
      value: self.localization.exportcsv
    });
    this.div.append(this.button);
    this.button.click(function() {
      self.exportCSV();
    });
  }

  // Sets the events
  $(document).ready(function () {
    // Build empty table
    self.buildTable();
    // On date change
    $(self.startDateId + ", " + self.endDateId).on("changeDate", function() {
      self.reloadTable();
    });
    // Initial data
    self.reloadTable();
  });

  // Build the initial table from the data
  this.buildTable = function() {
    var emptyTable = "<table class='table table-bordered'><thead><tr><th>" + this.localization.day + "</th>";
    for(var index in this.col_names) {
      emptyTable += "<th>" + this.col_names[index] + "</th>";
    }
    emptyTable += "</tr></thead><tbody><tr><td colspan='" + (this.feeds.length+1) + "' style='text-align:center;'>" + this.localization.nodata + "</td></tr></tbody>";
    this.table.append($(emptyTable));
  };

  // Reload data on date change
  this.reloadTable = function() {
    var startDate = this.getTimestamp($(this.startDateId + " :input").val(), false);
    var endDate = this.getTimestamp($(this.endDateId + " :input").val(), true);
    if((startDate === false) || (endDate === false)) {
      $(startDateId).addClass("error");
      $(endDateId).addClass("error");
      return;
    }
    var now = +new Date();
    if(startDate >= endDate) {
      $(this.startDateId + ", " + this.endDateId).addClass("error");
      return;
    }
    if((startDate >= now) || (endDate >= now)) {
      $(this.startDateId + ", " + this.endDateId).addClass("error");
      return;
    }
    $(this.startDateId + ", " + this.endDateId).removeClass("error");
    this.getData(startDate, endDate);
  };

  // Refresh the table's data
  this.getData = function(startDate, endDate) {
    // New data array (["d" + date] => [["f" + feedid] => value])
    var tmpData = [];
    // Requests array
    var requests = [];
    // Declare feed here so if the for loop has only 1 iteration we keep the feed index
    var feed;
    for(var index in this.feeds) {
      feed = this.feeds[index].id;
      requests.push(this.getFeedData(feed, startDate, endDate));
    }
    // Now
    var beginningDayNow = this.getBeginningOfDay(new Date());

    // Save context before jQuery calls
    var self = this;
    // When all requests finish
    $.when.apply($, requests).done(function() {
      // Special case if there is only one request
      if (requests.length == 1) {
        $.map(arguments[0], function(feedData) {
          // Normalize date
          feedData[0] = self.getBeginningOfDay(feedData[0]);
          // Between dates (and do not include today's data)
          if((feedData[0] >= (startDate + 60 * 1000)) && (feedData[0] < (endDate - 60 * 1000)) && (feedData[0] <= beginningDayNow)) {
            if(tmpData["d" + feedData[0]] == undefined) {
              tmpData["d" + feedData[0]] = [];
            }
            tmpData["d" + feedData[0]]["f" + feed] = feedData[1];
          }
        });
      }
      // For each request
      else {
        var index = 0;
        $.each(arguments, function(index, responseData) {
          $.map(responseData[0], function(feedData) {
            // Normalize date
            feedData[0] = self.getBeginningOfDay(feedData[0]);
            var feed = self.feeds[index].id;
            // Between dates (and do not include today's data)
            if((feedData[0] >= (startDate + 60 * 1000)) && (feedData[0] < (endDate - 60 * 1000)) && (feedData[0] <= beginningDayNow)) {
              if(tmpData["d" + feedData[0]] == undefined) {
                tmpData["d" + feedData[0]] = [];
              }
              tmpData["d" + feedData[0]]["f" + feed] = feedData[1];
            }
          });
          index++;
        });
      }
      // Substitute data
      self.feedData = tmpData;
      // Replace table data
      self.replaceTableData();
    });
  };

  // Get the beggining of the day of a date
  this.getBeginningOfDay = function(date) {
    var newDate = new Date(date);
    newDate.setHours(0);
    newDate.setMinutes(0);
    newDate.setSeconds(0);
    newDate.setMilliseconds(0);
    return newDate.getTime();
  }

  // Get feed data (async)
  this.getFeedData = function(id, start, end) {
    // 1 Day interval
    var interval = 60 * 60 * 24;
    // 2 days more of margin (will discard later on the data outside the selected range)
    start -= 60 * 60 * 24 * 1000;
    end += 60 * 60 * 24 * 1000;
    return $.ajax({
      url: window.emoncms_path + "/feed/data.json?apikey=" + window.apikey_read,
      data: "id="+id+"&start="+start+"&end="+end+"&interval="+interval+"&skipmissing=0&limitinterval=0",
      dataType: "json"
    });
  };

  // Insert the new data into the table and replace the old data
  this.replaceTableData = function() {
    var tbody = this.table.find("tbody");
    var nodatarow = "<tr><td colspan='" + (this.feeds.length+1) + "' style='text-align:center;'>" + this.localization.nodata + "</td></tr>";
    var tbodyHTML = "";
    tbody.empty();
    var numRows = 0;
    if(!$.isEmptyObject(this.feedData)) {
      // Data array (["d" + date] => [["f" + feedid] => value])
      for(var index in this.feedData) {
        var rowHTML = this.buildRow(parseInt(index.substring(1)), this.feedData[index]);
        if(rowHTML != "") {
          numRows++;
        }
        tbodyHTML += rowHTML;
      }
    }

    // No data check
    if(numRows == 0) {
      this.feedData = [];
      if(this.localization.nodata != "") {
        this.button.hide();
      }
      tbodyHTML += nodatarow;
    }

    // Show csv button
    if((this.localization.nodata != "") && (numRows != 0)) {
      this.button.show();
    }

    // Last row (total)
    var total = this.getTotalRow(this.feedData);
    var display = ((numRows > 1) && (this.localization.total != ""));
    var totalRow;
    if(display) {
      totalRow = "<tr><td>" + this.localization.total + "</td>";
    } else {
      totalRow = "<tr style='display: none;'><td>" + this.localization.total + "</td>";
    }
    var divIdNoHash = this.divId.substring(1);
    var triggerChanges = "";
    for(var index in total) {
      var totalData = Math.round(parseFloat(total[index]) * 100) / 100;
      totalRow += "<td id='" + divIdNoHash + "_total_" + index + "'>" + totalData + "</td>";
      triggerChanges += this.divId + "_total_" + index + ",";
    }
    totalRow += "</tr>";
    tbodyHTML += totalRow;

    // Append data
    tbody.html(tbodyHTML);

    // Trigger changes
    $(triggerChanges.substring(0, triggerChanges.length - 1)).trigger("change");
  };

  // Builds an html row
  this.buildRow = function(date, rowData) {
    // Flags
    var anydata = false;
    // Row string (html)
    var row = "";
    for(var index in this.col_names) {
      var col = this.col_names[index];
      var feedid = this.feed_ids[col];
      var colData = rowData[feedid] == null ? 0 : rowData[feedid];
      colData = Math.round(colData * 100) / 100;
      row += "<td>" + colData + "</td>";
      // Change flag
      if(rowData[feedid] != null) {
        anydata = true;
      }
    }
    // No data check
    if(anydata == false) {
      return "";
    }
    // Return row
    return "<tr><td>" + (new Date(date)).toLocaleDateString() + "</td>" + row + "</tr>";
  };

  // Translates a datetimepicker input to UNIX timestamp with appropiate offset
  this.getTimestamp = function (string, endDate) {
    var dateArray = string.split("/");
    if (dateArray.length != 3) {
      return false;
    }
    var date = (+new Date(dateArray[2], dateArray[1] - 1, dateArray[0]));
    // If date is today, and it is the end date, set it to now
    if(endDate) {
      // End of the day plus one minute
      date += 60 * 60 * 24 * 1000 + 60 * 1000;
    } else {
      // Start of the day minus one minute
      date -= 60 * 1000;
    }
    return date;
  };

  // Exports the table to csv
  this.exportCSV = function() {
    var self = this;
    if($.isEmptyObject(this.feedData)) {
      alert(self.localization.nodata);
      return;
    }
    // CSV header
    var csvheader = this.localization.day + "," + this.col_names.join(",") + "\r\n";

    // Data array (["d" + date] => [["f" + feedid] => value])
    var csvstring = "";
    var numRows = 0;
    var maxDate = 0;
    var minDate = +new Date();
    for(var index in this.feedData) {
      var date = parseInt(index.substring(1));
      if(date > maxDate) {
        maxDate = date;
      }
      if(date < minDate) {
        minDate = date;
      }
      var rowCSV = this.getCSVRow(date, this.feedData[index]);
      if(rowCSV != "") {
        numRows++;
      }
      csvstring += rowCSV;
    }
    // No data check
    if(numRows == 0) {
      alert(this.localization.nodata);
      return;
    }
    if((numRows > 1) && (this.localization.total != "")) {
      // Last row
      csvstring += this.getTotalRowCSV(this.feedData);
    }

    // Download data
    this.downloadCSV((new Date(minDate)).toLocaleDateString() + "---" + (new Date(maxDate)).toLocaleDateString(), csvheader + csvstring);
  };

  // Get a csv row
  this.getCSVRow = function(date, rowData) {
    // Flag
    var anydata = false;
    // Row array (columns)
    var row = [];
    for(var index in this.col_names) {
      var col = this.col_names[index];
      var feedid = this.feed_ids[col];
      var colData = rowData[feedid] == null ? 0 : rowData[feedid];
      row.push(colData);
      // Change flag
      if(rowData[feedid] != null) {
        anydata = true;
      }
    }
    // No data check
    if(!anydata) {
      return "";
    }

    // Return row
    return (new Date(date)).toLocaleDateString() + "," + row.join(",") + "\r\n";
  };

  // Gets the total row in csv
  this.getTotalRowCSV = function(feedData) {
    var row = this.getTotalRow(feedData);
    var rowCSV = "";
    for(var index in row) {
      rowCSV += row[index] + ",";
    }
    rowCSV = rowCSV.substring(0, rowCSV.length - 1);
    return this.localization.total + "," + rowCSV + "\r\n";
  }

  // Gets the total row
  this.getTotalRow = function(feedData) {
    var total = [];
    if(Object.keys(feedData).length == 0) {
      for(var index in this.feeds) {
        var feedid = this.feeds[index].id;
        total["f" + feedid] = 0;
      }
      return total;
    }
    for(var date in feedData) {
      for(var index in this.feeds) {
        var feedid = this.feeds[index].id;
        if(total["f" + feedid] === undefined) {
          total["f" + feedid] = 0;
        }
        if(feedData[date]["f" + feedid] != null) {
          total["f" + feedid] += parseFloat(feedData[date]["f" + feedid]);
        }
      }
    }
    return total;
  }

  // Download a csv
  this.downloadCSV = function(name, data) {
    // Create a temporary link and trigger its click
    var D = document;
    var a = D.createElement("a");
    a.href = 'data:text/csv;charset=UTF-8,' + encodeURIComponent(data);
    a.setAttribute("download", name + ".csv");
    D.body.appendChild(a);
    setTimeout(function() {
      a.click();
      D.body.removeChild(a);
    }, 100);
  };
};
