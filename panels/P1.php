<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

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
      ?>
      <div>
        <span>sPLoad:</span>
        <span class="instant-feed" data-feedid="<?php echo $this->feeds['sPLoad']['id']; ?>">
          <?php echo $this->feeds['sPLoad']['value']; ?>
        </span>
        <span> (units)</span>
      </div>
      <div>
        <span>sVoltage:</span>
        <span class="instant-feed" data-feedid="<?php echo $this->feeds['sVoltage']['id']; ?>">
          <?php echo $this->feeds['sVoltage']['value']; ?>
        </span>
        <span> (units)</span>
      </div>
      <div id="sPLoad"></div>
      <div>
        <span>eDLoad:</span>
        <span class="instant-feed" data-feedid="<?php echo $this->feeds['eDLoad']['id']; ?>">
          <?php echo $this->feeds['eDLoad']['value']; ?>
        </span>
        <span> (units)</span>
      </div>
      <div id="eDLoad"></div>
      <script>
        $(window).on('load', function() {
          // sPLoad graphic
          var sPLoad = [
            {
              id: <?php echo $this->feeds['sPLoad']['id']; ?>,
              color: "#00ABE3",
              legend: "sPLoad"
            }
          ];
          FeedChartFactory.create("sPLoad", sPLoad);
          // eDLoad graphic
          var eDLoad = [
            {
              id: <?php echo $this->feeds['eDLoad']['id']; ?>,
              color: "#00E37D",
              legend: "eDLoad"
            }
          ];
          FeedChartFactory.create("eDLoad", eDLoad, {chartType: "daily"});
        });
      </script>
      <?php
    }
  }
?>
