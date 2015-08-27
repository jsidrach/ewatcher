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
        // Value: tLoad, tPv, tPvToLoad, tPvToNet, tLoadFromNet (cumulative feeds), 100*tPvToLoad/tPv, 100*tPvToLoad/tLoad (dependent feeds)
        // Value: cNet, cPvToNet, cLoadNoPv, cLoadPv, savings (dependent feeds)
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
      <div class="multiple-values-container">
        <div class="formDates">
          <div class="dateInput">
            <label><?php echo ewatcher_translate("Start date"); ?></label>
            <div id="startDate" class="input-append date control-group">
              <input data-format="dd/MM/yyyy" value="<?php echo date("d/m/Y", strtotime('-7 days')); ?>" type="text" />
              <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
            </div>
          </div>
          <div class="dateInput">
            <label><?php echo ewatcher_translate("End date"); ?></label>
            <div id="endDate" class="input-append date control-group">
              <input data-format="dd/MM/yyyy" value="<?php echo date("d/m/Y"); ?>" type="text" />
              <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-3">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Total consumption"); ?></label>
            <span id="tLoad" data-feedid="<?php echo $this->feeds['tLoad']['id']; ?>">
            </span>
            <span>kWh</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Generated PV energy"); ?></label>
            <span id="tPv" data-feedid="<?php echo $this->feeds['tPv']['id']; ?>">
            </span>
            <span>kWh</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Self-consumed PV energy"); ?></label>
            <span id="tPvToLoad" data-feedid="<?php echo $this->feeds['tPvToLoad']['id']; ?>">
            </span>
            <span>kWh</span>
          </span>
        </div>
      </div>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-2">
          <span class="single-value">
            <label><?php echo ewatcher_translate("PV energy injected into the net"); ?></label>
            <span id="tPvToNet" data-feedid="<?php echo $this->feeds['tPvToNet']['id']; ?>">
            </span>
            <span>kWh</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("PV energy imported from the net"); ?></label>
            <span id="tLoadFromNet" data-feedid="<?php echo $this->feeds['tLoadFromNet']['id']; ?>">
            </span>
            <span>kWh</span>
          </span>
      </div>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-2">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Percentage of self-consumption"); ?></label>
            <span id="tLoad" data-feedid="<?php echo 100*$this->feeds['tPvToLoad/tPv']['id']/$this->feeds['tPv']['id']; ?>">
            </span>
            <span>%</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Percentage of consumption generated by PV"); ?></label>
            <span id="tLoad" data-feedid="<?php echo 100*$this->feeds['tPvToLoad/tPv']['id']/$this->feeds['tLoad']['id']; ?>">
            </span>
            <span>%</span>
          </span>
        </div>
      </div>
      <hr>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-2">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Cost of the imported energy"); ?></label>
            <span id="tLoad" data-feedid=
            "<?php
            $cNet = 0.1244*$this->feeds['tLoadFromNet']['id'];
            echo $cNet;
            ?>">
            </span>
            <span>€</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Cost of the energy injected into the net"); ?></label>
            <span id="tPv" data-feedid=
            "<?php
            $cPvToNet = 0.054*$this->feeds['tPvToNet']['id'];
            echo $cPvToNet;
            ?>">
            </span>
            <span>€</span>
          </span>
        </div>
      </div>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-3">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Cost without PV production"); ?></label>
            <span id="tPvToLoad" data-feedid=
            "<?php
            $cLoadNoPv = 0.1244*$this->feeds['tLoad']['id'];
            echo $cLoadNoPv;
            ?>">
            </span>
            <span>€</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Cost with PV production"); ?></label>
            <span id="tPvToNet" data-feedid=
            "<?php
            $cLoadPv = $cNet - $cPvToNet;
            echo $cLoadPv;
            ?>">
            </span>
            <span>€</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Savings"); ?></label>
            <span id="tLoadFromNet" data-feedid=
            "<?php
            echo $cLoadNoPv-$cLoadPv;
            ?>">
            </span>
            <span>€</span>
          </span>
        </div>
      </div>
      <hr>
      <div class="daily-values" id="table"></div>
      <script>
        $(window).ready(function () {
          $('#startDate').datetimepicker({ pickTime: false });
          $('#endDate').datetimepicker({ pickTime: false });
          //var tLoad = new CumulativeFeed("#tLoad", "#startDate", "#endDate");
          var dailyTable = new FeedDailyTable("#table", "#startDate", "#endDate", [
            {
              id: <?php echo $this->feeds['eDLoad']['id']; ?>,
              name: 'Consumption (kWh/d)'
            },
            {
              id: <?php echo $this->feeds['eDPv']['id']; ?>,
              name: 'PV energy (kWh/d)'
            },
            {
              id: <?php echo $this->feeds['eDLoadFromPv']['id']; ?>,
              name: 'Self-consumed PV energy (kWh/d)'
            },
            {
              id: <?php echo $this->feeds['eDPvToNet']['id']; ?>,
              name: 'PV energy injected into the net (kWh/d)'
            },
            {
              id: <?php echo $this->feeds['eDNet']['id']; ?>,
              name: 'PV energy imported from the net (kWh/d)'
            }
          ]);
        });
      </script>
      <?php
    }
  }
?>
