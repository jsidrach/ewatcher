// Sets the events
$(document).ready(function () {
  InstantLed.init();
});

//
// InstantLed module
//   Automatic update of led every X seconds
//
// Variables needed: window.apikey_read, window.emoncms_path
// Libraries needed: jQuery
(function (InstantLed, $, undefined) {
  "use strict";

  // Number of seconds between updates
  var interval = 10000;

  // Intervals (return of setInterval)
  var intervals = [];

  // Color for OK
  var colorOK = "#20CA36";
  // Color for Error
  var colorError = "#D52E2E";

  // Initializes the module
  InstantLed.init = function () {
    // Refresh led
    // Feed label/span must have:
    //   instant-led class
    //   data attribute called feedid
    // Example: <span class="instant-feed" data-feedid="0"></span>
    $(".instant-led").each(function() {
      var feedElement = $(this);
      intervals.push(setInterval(function() {
        InstantLed.getVal(feedElement.data("feedid"), function(value) {
          if((typeof value === "object") && ("success" in value) && (value.success == false)) {
            //feedElement.text("--");
            // Don't set the text
          } else {
            var floatVal = parseFloat(value);
            if(floatVal == 1) {
              feedElement.css("background-color", colorError);
            } else {
              feedElement.css("background-color", colorOK);
            }
          }
        });
      }, interval));
    });
  };

  // Gets the last value of a feed
  InstantLed.getVal = function (id, callback) {
    $.ajax({
      type: "GET",
      url: window.emoncms_path + "feed/value.json?id=" + id + "&apikey=" + window.apikey_read,
      success: function(result) {
        callback(result);
      }
    });
  };

  // Set interval
  InstantLed.setInterval = function(newInterval) {
    interval = newInterval;
    // Stop all callbacks
    intervals.forEach(function(refreshInterval) {
      clearInterval(refreshInterval);
    });
    // Set new intervals
    intervals = [];
    InstantLed.init();
  };

}(window.InstantLed = window.InstantLed || {}, jQuery));
