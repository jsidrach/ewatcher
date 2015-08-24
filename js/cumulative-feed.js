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
  this.divId = divId;
  this.startDateId = startDateId;
  this.endDateId = endDateId;

  // Object properties
  this.feedId = $(divId).data("feedid");

  // Save context
  var self = this;
  // Sets the events
  $(document).ready(function () {
    // On date change
    $(self.startDateId + ", " + self.endDateId).on('changeDate', function() {
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
      return;
    }
    var now = +new Date();
    if(startDate >= endDate) {
      alert('Invalid date range');
      return;
    }
    if((startDate >= now) || (endDate >= now)) {
      alert('Invalid date range (future dates)');
      return;
    }
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
    if((endDate) && ((now - date) < 60*60*24*1000)) {
      date = now - 1000;
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
        }
        $(self.divId).text(lastValue - firstValue);
      }
    });
  };
};
