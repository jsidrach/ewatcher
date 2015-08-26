<?php
  // P4 Class
  // PV - Queries
  class EWatcherP4 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path, $config) {
      parent::__construct($userid, $mysqli, $path, $config);
    }

    // Panel 4 View
    public function view() {
      parent::view();

      // (Optional) set: cIn, cOut, units
      // Form: two dates (default to all)
        // Value: tLoad, tPv, tPvToLoad, tPvToNet, tLoadFromNet, 100*tPvToLoad/tPv, 100*tPvToLoad/tLoad
        // Value (from retrieved values): cNet, cPvToNet, cLoadNoPv, cLoadPv, savings
        // Table: eDLoad, eDPv, eDLoadFromPv, eDPvToNet, eDNet (daily between the dates)
      ?>
      <div id="ewatcher-config" class="ewatcher-config">
        <div class="default-hidden-config" style="display:none">
          <div class="multiple-values-container">
            <div class="multiple-values multiple-3">
              <span class="single-value">
                <label><?php echo ewatcher_translate("Import cost"); ?></label>
                <input id="cIn" type="number" value="<?php echo $this->config->getcin(); ?>" step="any">
              </span>
              <span class="single-value">
                <label><?php echo ewatcher_translate("Units"); ?></label>
                <input id="units" type="text" value="<?php echo $this->config->getunits(); ?>">
              </span>
                <span class="single-value">
                <label><?php echo ewatcher_translate("Export cost"); ?></label>
                <input id="cOut" type="number" value="<?php echo $this->config->getcout(); ?>" step="any">
              </span>
            </div>
          </div>
          <i class="icon-arrow-up icon-white click-close"></i>
        </div>
        <div class="default-shown-config">
          <i class="icon-wrench icon-white click-open"></i>
        </div>
        <hr>
      </div>
      <script>
        $(window).ready(function() {
          var config = new EWatcherConfigPanel("#ewatcher-config", "#cIn", "#cOut", "#units");
        });
      </script>
      <?php
    }
  }
?>
