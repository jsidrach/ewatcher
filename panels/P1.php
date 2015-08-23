<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P1 Class
  // Consumption
  class EWatcherP1 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path) {
      parent::__construct($userid, $mysqli, $path);
    }

    // Panel 1 View
    public function view() {
      parent::view();

      // Value: sPLoad, sVoltage
      // Graphic: sPLoad (last 7 values + interactivity)
      // Value: eDLoad
      // Graphic: eDLoad (last 7 values + interactivity)
      echo "TODO P1";
      echo strval($this->feeds['sPLoad']['id']);
      ?>
      <span class="instant-feed" data-feedid="357">Test</span>
      <div id="test"></div>
      <div id="test2"></div>
      <script>
        $(window).on('load', function() {
          var feeds = [
            {
              id: 601,
              color: "#123123",
              legend: "Test legend 1"
            },
            {
              id: 589,
              color: "#122223",
              legend: "Test legend 2"
            }
          ];
          FeedChartFactory.create("test", feeds);
          FeedChartFactory.create("test2", feeds);
        });
      </script>
      <?php
    }
  }
?>
