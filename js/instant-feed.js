// Sets the events
$(document).ready(function () {
  InstantFeed.init();
});

//
// InstantFeed module
//   Automatic update of a feed value every X seconds
//
// Variables needed: window.apikey_read, window.emoncms_path
// Libraries needed: jQuery
(function (InstantFeed, $, undefined) {
  "use strict";

  // Number of seconds between updates
  var interval = 10000;

  // Intervals (return of setInterval)
  var intervals = [];

  // Defaults
  // Multiply the retrieved value
  var scale = 1;
  // Precision (1 = no decimals, 10 = one decimal, etc.)
  var precision = 100;

  // Initializes the module
  InstantFeed.init = function () {
    // Refresh feed
    // Feed label/span must have:
    //   instant-feed class
    //   data attribute called feedid
    // Example: <span class="instant-feed" data-feedid="0"></span>
    $(".instant-feed").each(function() {
      var feedElement = $(this);
      intervals.push(setInterval(function() {
        InstantFeed.getVal(feedElement.data("feedid"), function(value) {
          var feedScale = parseFloat(feedElement.data("scale") == undefined ? scale : feedElement.data("scale"));
          var feedPrecision = parseFloat(feedElement.data("precision") == undefined ? precision : feedElement.data("precision"));
          if((typeof value === "object") && ("success" in value) && (value.success == false)) {
            //feedElement.text("--");
            // Don't set the text
          } else {
            feedElement.text(Math.round(parseFloat(value) * feedScale * feedPrecision) / feedPrecision).trigger("change");
          }
        });
      }, interval));
    });
  };

  // Gets the last value of a feed
  InstantFeed.getVal = function (id, callback) {
    $.ajax({
      type: "GET",
      url: window.emoncms_path + "feed/value.json?id=" + id + "&apikey=" + window.apikey_read,
      success: function(result) {
        callback(result);
      }
    });
  };

  // Set interval
  InstantFeed.setInterval = function(newInterval) {
    interval = newInterval;
    // Stop all callbacks
    intervals.forEach(function(refreshInterval) {
      clearInterval(refreshInterval);
    });
    // Set new intervals
    intervals = [];
    InstantFeed.init();
  };

}(window.InstantFeed = window.InstantFeed || {}, jQuery));
