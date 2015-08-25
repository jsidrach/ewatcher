<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // P3 Class
  // PV
  class EWatcherP3 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path) {
      parent::__construct($userid, $mysqli, $path);
    }

    // Panel 3 View
    public function view() {
      parent::view();

      // Value: sPLoad, sPPv, iGridToLoad
      // Graphic: sPLoad, sPPv, iGridToLoad (last 7 days + interactivity)
      // Value: eDPv, eDLoadFromPv, eDPvToNet, eDNet, eDLoad
      // Value: dPLoadFromPv, dPSelf
      echo "TODO P3";
    }
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
      <div class="multiple-values multiple-2">
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
      </div>
      <div class="multiple-values multiple-1">
        <span class="single-value">
          <label><?php echo ewatcher_translate("Power now"); ?></label>
          <span class="instant-feed" data-feedid="<?php echo $this->feeds['sPLoad']['id']; ?>">
            <?php echo $this->feeds['sPLoad']['value']; ?>
          </span>
          <span>W</span>
        </span>
      </div>
    </div>
    <?php
  }
?>
