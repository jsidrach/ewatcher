// CumulativeFeed class
// Variables needed: window.apikey_read, window.emoncms_path
// Libraries needed: jQuery, bootstrap-datetimepicker
//
// Parameters:
//   divId: id of the feed value container
//   startDateId: id of the start date input
//   endDateId: id of the end date input
function CumulativeFeed(divId, startDateId, endDateId) {
  "use strict";

  // Parameter properties
  // Container id
  this.divId = divId;
  // Id of the start date of the cumulative feed
  this.startDateId = startDateId;
  // Id of the end date of the cumulative feed
  this.endDateId = endDateId;

  // Object properties
  // Number of feed (id)
  this.feedId = $(divId).data("feedid");

  // Save context
  var self = this;
  // Sets the events
  $(document).ready(function () {
    // On date change
    $(self.startDateId + ", " + self.endDateId).on("changeDate", function() {
      self.reloadData();
    });
    // Initial data
    self.reloadData();
  });

  // Reload data on date change
  this.reloadData = function() {
    var startDate = this.getTimestamp($(this.startDateId + " :input").val(), false);
    var endDate = this.getTimestamp($(this.endDateId + " :input").val(), true);
    if((startDate === false) || (endDate === false)) {
      $(startDateId).addClass("error");
      $(endDateId).addClass("error");
      return;
    }
    // If they are both the same
    if(startDate == endDate) {
      // + 1 day minus 30 seconds
      endDate += 24 * 1000 * 60 * 60 - 30000;
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
    this.refreshData(startDate, endDate);
  };

  // Translates a datetimepicker input to UNIX timestamp with appropiate offset
  this.getTimestamp = function (string, endDate) {
    var dateArray = string.split("/");
    if (dateArray.length != 3) {
      return false;
    }
    var date = (+new Date(dateArray[2], dateArray[1] - 1, dateArray[0]));
    var now = +new Date();
    // Date >= now (error check in the parent call)
    if(date >= now) {
      return date;
    }
    // If date is today, and it is the end date, set it to now
    if((endDate) && ((now - date) < 60 * 60 * 24 * 1000)) {
      // At least 30 seconds so data is available
      date = now - 30000;
    }
    return date;
  };

  // Refresh feed data (async)
  this.refreshData = function(start, end) {
    var self = this;
    var interval = (end - start) * 0.001 + 1;
    $.ajax({
      url: window.emoncms_path + "/feed/data.json?apikey=" + window.apikey_read,
      data: "id="+self.feedId+"&start="+start+"&end="+end+"&interval="+interval+"&skipmissing=0&limitinterval=1",
      dataType: "json",
      success: function(data) {
        var value;
        // Special case
        if((data.length == 1)) {
          if(data[0][1] == null) {
            value = 0;
          } else {
            value = data[0][1];
          }
        }
        // Difference
        else {
          var lastValue = data[1][1];
          if(lastValue == null) {
            lastValue = 0;
          }
          var firstValue = data[0][1];
          if(firstValue == null) {
            firstValue = 0;
          }
          value = lastValue - firstValue;
        }
        $(self.divId).text(Math.round(parseFloat(value) * 100) / 100).trigger("change");
      }
    });
  };
};
