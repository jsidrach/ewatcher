<?php
  // P1 Class
  // Consumption
  class EWatcherP1 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path, $config) {
      parent::__construct($userid, $mysqli, $path, $config);
    }

    // Panel 1 View
    public function view() {
      parent::view();

      // Value: sPLoad, sVoltage, eDLoad (intant feeds)
      // Graphic: sPLoad (last 7 values + interactivity), continuous graph
      // Graphic: eDLoad (last 7 values + interactivity), daily graph
      ?>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-3">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Consumption"); ?></label>
            <span class="instant-feed" data-feedid="<?php echo $this->feeds['sPLoad']['id']; ?>">
              <?php echo $this->feeds['sPLoad']['value']; ?>
            </span>
            <span>W</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Voltage"); ?></label>
            <span class="instant-feed" data-feedid="<?php echo $this->feeds['sVoltage']['id']; ?>">
              <?php echo $this->feeds['sVoltage']['value']; ?>
            </span>
            <span>V</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Energy consumed today"); ?></label>
            <span class="instant-feed" data-feedid="<?php echo $this->feeds['eDLoad']['id']; ?>">
              <?php echo $this->feeds['eDLoad']['value']; ?>
            </span>
            <span>kWh</span>
          </span>
        </div>
      </div>
      <div id="sPLoad"></div>
      <div id="eDLoad"></div>
      <script>
        $(window).ready(function() {
          // sPLoad graphic
          var sPLoad = [
            {
              id: <?php echo $this->feeds['sPLoad']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Consumption (W)'); ?>",
              fill: 0.7,
              line: 1
            }
          ];
          FeedChartFactory.create("sPLoad", sPLoad, {defaultRange: 1, steps: false});
          // eDLoad graphic
          var eDLoad = [
            {
              id: <?php echo $this->feeds['eDLoad']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Daily energy consumption (kWh)'); ?>"
            }
          ];
          FeedChartFactory.create("eDLoad", eDLoad, {chartType: "daily"});
        });
      </script>
      <?php
    }
  }
?>
