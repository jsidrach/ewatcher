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
      echo "TODO P1";?>
      <span class="instant-feed" data-feedid="357">Test</span>
      <div id="test"></div>
      <script>
        $(window).on('load', function() {
          FeedLineChartFactory.create("test", 40, 7);
        });
      </script>
      <?php
    }
  }
?>
