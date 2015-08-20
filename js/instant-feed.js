// Sets the events
$(document).ready(function () {
  InstantFeed.init();
});

//
// InstantFeed module
//   Reloads every X second the value of every instant-feed in the page
//
// Needs: window.apikey_read, window.emoncms_path
(function (InstantFeed, $, undefined) {
  // Number of seconds between updates
  var interval;

  // Initializes the module
  InstantFeed.init = function () {
    // Set the internal variables
    interval = 10000;

    // Refresh feed
    // Feed label/span must have:
    //   instant-feed class
    //   data attribute called feedid
    // Example: <span class="instant-feed" data-feedid="0"></span>
    $(".instant-feed").each(function() {
      var feedElement = $(this);
      setInterval(function() {
        InstantFeed.getVal(feedElement.data("feedid"), function(value) {
          if((typeof value === 'object') && ("success" in value) && (value.success == false)) {
            feedElement.text("--");
          } else {
            feedElement.text(value);
          }
        });
      }, interval);
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

}(window.InstantFeed = window.InstantFeed || {}, jQuery));
