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
              id: 598,
              color: "#122223",
              legend: "Test legend 2"
            },
            {
              id: 602
            }
          ];
          FeedChartFactory.create("test", feeds, {chartType: "daily"});
        });
      </script>
      <?php
    }
  }
?>
