// Sets the events
$(document).ready(function () {
  InstantFeed.init();
});

//
// InstantFeed module
//   Reloads every X second the value of every instant-feed in the page
//
// Variables needed: window.apikey_read, window.emoncms_path
// Libraries needed: jQuery
(function (InstantFeed, $, undefined) {
  "use strict";

  // Number of seconds between updates
  var interval = 10000;

  // Intervals (return of setInterval)
  var intervals = [];

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
          if((typeof value === 'object') && ("success" in value) && (value.success == false)) {
            //feedElement.text("--");
            // Don't set the text
          } else {
            feedElement.text(value).trigger('change');
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
