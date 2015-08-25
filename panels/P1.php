<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // Translations
  require_once("Modules/ewatcher/ewatcher_translations.php");

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
      ?>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-3">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Power now"); ?></label>
            <span class="instant-feed" data-feedid="<?php echo $this->feeds['sPLoad']['id']; ?>">
              <?php echo $this->feeds['sPLoad']['value']; ?>
            </span>
            <span>W</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Voltage now"); ?></label>
            <span class="instant-feed" data-feedid="<?php echo $this->feeds['sVoltage']['id']; ?>">
              <?php echo $this->feeds['sVoltage']['value']; ?>
            </span>
            <span>V</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Today's consumption"); ?></label>
            <span class="instant-feed" data-feedid="<?php echo $this->feeds['eDLoad']['id']; ?>">
              <?php echo $this->feeds['eDLoad']['value']; ?>
            </span>
            <span>kWh/d</span>
          </span>
        </div>
      </div>
      <div id="sPLoad"></div>
      <div id="eDLoad"></div>
      <script>
        $(window).on('load', function() {
          // sPLoad graphic
          var sPLoad = [
            {
              id: <?php echo $this->feeds['sPLoad']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Energy consumption (W)'); ?>"
            }
          ];
          FeedChartFactory.create("sPLoad", sPLoad, {defaultRange: 1});
          // eDLoad graphic
          var eDLoad = [
            {
              id: <?php echo $this->feeds['eDLoad']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Daily consumption (kW/d)'); ?>"
            }
          ];
          FeedChartFactory.create("eDLoad", eDLoad, {chartType: "daily"});
        });
      </script>
      <?php
    }
  }
?>
