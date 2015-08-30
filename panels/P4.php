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

      // (Optional Configuration) set: cIn, cOut, units
      // Form: two dates (default to one week)
        // Value: tLoad, tPv, tPvToLoad, tPvToGrid, tLoadFromGrid (cumulative feeds), 100*tPvToLoad/tPv, 100*tPvToLoad/tLoad (dependent feeds)
        // Value: cGrid, cPvToGrid, cLoadNoPv, cLoadPv, savings (dependent feeds)
        // Table: eDLoad, eDPv, eDLoadFromPv, eDPvToGrid, eDGrid, dPSelf, dPLoadFromPv (daily table)
      ?>
      <div id="ewatcher-config" class="ewatcher-config">
        <div class="default-hidden-config" style="display:none">
          <div class="multiple-values-container">
            <div class="multiple-values multiple-3">
              <span class="single-value">
                <label><?php echo ewatcher_translate("Energy imported cost (per kWh)"); ?></label>
                <input id="cIn" type="number" value="<?php echo $this->config->getcin(); ?>" step="any">
              </span>
              <span class="single-value">
                <label><?php echo ewatcher_translate("Currency"); ?></label>
                <input id="units" type="text" value="<?php echo $this->config->getunits(); ?>">
              </span>
                <span class="single-value">
                <label><?php echo ewatcher_translate("Energy exported cost (per kWh)"); ?></label>
                <input id="cOut" type="number" value="<?php echo $this->config->getcout(); ?>" step="any">
              </span>
            </div>
          </div>
          <span class="click-close"><i class="icon-arrow-up icon-white"></i></span>
        </div>
        <div class="default-shown-config">
          <span class="click-open"><?php echo ewatcher_translate("Energy costs"); ?><i class="icon-wrench icon-white"></i></span>
        </div>
        <hr>
      </div>
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
              <input data-format="dd/MM/yyyy" value="<?php echo date("d/m/Y", strtotime('-1 days')); ?>" type="text" />
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
            <label><?php echo ewatcher_translate("PV energy produced"); ?></label>
            <span id="tPv" class="ewatcher-yellow" data-feedid="<?php echo $this->feeds['tPv']['id']; ?>">
            </span>
            <span class="ewatcher-yellow">kWh</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("PV self-consumed energy"); ?></label>
            <span id="tPvToLoad"  class="ewatcher-yellow" data-feedid="<?php echo $this->feeds['tPvToLoad']['id']; ?>">
            </span>
            <span class="ewatcher-yellow">kWh</span>
          </span>
        </div>
      </div>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-2">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Energy imported from the grid"); ?></label>
            <span id="tLoadFromGrid"  class="ewatcher-red" data-feedid="<?php echo $this->feeds['tLoadFromGrid']['id']; ?>">
            </span>
            <span class="ewatcher-red">kWh</span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("PV energy exported to the grid"); ?></label>
            <span id="tPvToGrid"  class="ewatcher-yellow" data-feedid="<?php echo $this->feeds['tPvToGrid']['id']; ?>">
            </span>
            <span class="ewatcher-yellow">kWh</span>
          </span>
        </div>
      </div>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-2">
          <span title="<?php echo ewatcher_translate('Self-consumed energy relative to the total PV energy produced'); ?>" class="single-value">
            <label><?php echo ewatcher_translate("Self-consumption"); ?></label>
            <span id="selfConsumption" class="ewatcher-green"></span>
            <span class="ewatcher-green">%</span>
          </span>
          <span title="<?php echo ewatcher_translate('Self-consumed energy relative to the total load'); ?>" class="single-value">
            <label><?php echo ewatcher_translate("Self-sufficiency"); ?></label>
            <span id="selfSufficiency" class="ewatcher-yellow"></span>
            <span class="ewatcher-yellow">%</span>
          </span>
        </div>
      </div>
      <hr>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-2">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Cost of the imported energy"); ?></label>
            <span id="cGrid" class="ewatcher-red"></span>
            <span class="cost-units ewatcher-red"><?php echo $this->config->getUnits(); ?></span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Cost of the exported PV energy"); ?></label>
            <span id="cPvToGrid" class="ewatcher-yellow"></span>
            <span class="cost-units ewatcher-yellow"><?php echo $this->config->getUnits(); ?></span>
          </span>
        </div>
      </div>
      <div class="multiple-values-container">
        <div class="multiple-values multiple-2">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Cost without PV production"); ?></label>
            <span id="cLoadNoPv" class="ewatcher-red"></span>
            <span class="cost-units ewatcher-red"><?php echo $this->config->getUnits(); ?></span>
          </span>
          <span class="single-value">
            <label><?php echo ewatcher_translate("Cost with PV production"); ?></label>
            <span id="cLoadPv" class="ewatcher-yellow"></span>
            <span class="cost-units ewatcher-yellow"><?php echo $this->config->getUnits(); ?></span>
          </span>
        </div>
        <div class="multiple-values-container">
          <div class="multiple-values multiple-1">
            <span class="single-value">
              <label><?php echo ewatcher_translate("Estimated savings"); ?></label>
              <span id="savings" class="ewatcher-green"></span>
              <span class="cost-units ewatcher-green"><?php echo $this->config->getUnits(); ?></span>
            </span>
          </div>
        </div>
      </div>
      <hr>
      <div class="daily-values several-values" id="table"></div>
      <script>
        $(window).ready(function() {
          // Configuration panel
          var config = new EWatcherConfigPanel("#ewatcher-config", "#cIn", "#cOut", "#units");
          // Date form
          $('#startDate').datetimepicker({ pickTime: false });
          $('#endDate').datetimepicker({ pickTime: false });
          // Units
          var costUnits = new DependentValue(".cost-units", "#units", function(values) {
            return values["#units"];
          });
          // Dependent values (get it from the tables)
          // The table has a final total row (may be hidden) with the sum of each column, and the id of each column total is #total_f<feedid>
          var tLoad = new DependentValue("#tLoad", "#total_f<?php echo $this->feeds['eDLoad']['id']; ?>", function(values) {
            return parseFloat(values["#total_f<?php echo $this->feeds['eDLoad']['id']; ?>"]);
          });
          var tPv = new DependentValue("#tPv", "#total_f<?php echo $this->feeds['eDPv']['id']; ?>", function(values) {
            return parseFloat(values["#total_f<?php echo $this->feeds['eDPv']['id']; ?>"]);
          });
          var tLoadFromGrid = new DependentValue("#tLoadFromGrid", "#total_f<?php echo $this->feeds['eDGrid']['id']; ?>", function(values) {
            return parseFloat(values["#total_f<?php echo $this->feeds['eDGrid']['id']; ?>"]);
          });
          // Dependent values from the total values
          var tPvToLoad = new DependentValue("#tPvToLoad", "#tLoad,#tLoadFromGrid", function(values) {
            var tLoad = parseFloat(values["#tLoad"]);
            var tLoadFromGrid = parseFloat(values["#tLoadFromGrid"]);
            return (Math.round((tLoad - tLoadFromGrid) * 100) / 100);
          });
          var tPvToGrid = new DependentValue("#tPvToGrid", "#tPv,#tPvToLoad", function(values) {
            var tPv = parseFloat(values["#tPv"]);
            var tPvToLoad = parseFloat(values["#tPvToLoad"]);
            return (Math.round((tPv - tPvToLoad) * 100) / 100);
          });
          // Dependent values
          var selfConsumption = new DependentValue("#selfConsumption", "#tPvToLoad,#tPv", function(values) {
            var tPvToLoad = parseFloat(values["#tPvToLoad"]);
            var tPv = parseFloat(values["#tPv"]);
            if(tPv == 0) {
              return 0;
            }
            return (Math.round(100 * 100 * tPvToLoad / tPv) / 100);
          });
          var selfSufficiency = new DependentValue("#selfSufficiency", "#tPvToLoad,#tLoad", function(values) {
            var tPvToLoad = parseFloat(values["#tPvToLoad"]);
            var tLoad = parseFloat(values["#tLoad"]);
            if(tLoad == 0) {
              return 0;
            }
            return (Math.round(100 * 100 * tPvToLoad / tLoad) / 100);
          });
          // Costs
          var cGrid = new DependentValue("#cGrid", "#cIn,#tLoadFromGrid", function(values) {
            var cIn = parseFloat(values["#cIn"]);
            var tLoadFromGrid = parseFloat(values["#tLoadFromGrid"]);
            return Math.round(cIn * tLoadFromGrid * 100) / 100;
          });
          var cPvToGrid = new DependentValue("#cPvToGrid", "#cOut,#tPvToGrid", function(values) {
            var cOut = parseFloat(values["#cOut"]);
            var tPvToGrid = parseFloat(values["#tPvToGrid"]);
            return Math.round(cOut * tPvToGrid * 100) / 100;
          });
          var cLoadNoPv = new DependentValue("#cLoadNoPv", "#cIn,#tLoad", function(values) {
            var cIn = parseFloat(values["#cIn"]);
            var tLoad = parseFloat(values["#tLoad"]);
            return Math.round(cIn * tLoad * 100) / 100;
          });
          var cLoadPv = new DependentValue("#cLoadPv", "#cGrid,#cPvToGrid", function(values) {
            var cGrid = parseFloat(values["#cGrid"]);
            var cPvToGrid = parseFloat(values["#cPvToGrid"]);
            return Math.round((cGrid - cPvToGrid) * 100) / 100;
          });
          var savings = new DependentValue("#savings", "#cLoadPv,#cLoadNoPv", function(values) {
            var cLoadPv = parseFloat(values["#cLoadPv"]);
            var cLoadNoPv = parseFloat(values["#cLoadNoPv"]);
            return Math.round((cLoadNoPv - cLoadPv) * 100) / 100;
          });
          // Table
          var dailyTable = new FeedDailyTable("#table", "#startDate", "#endDate", [
            {
              id: <?php echo $this->feeds['eDLoad']['id']; ?>,
              name: '<?php echo ewatcher_translate("Consumption (kWh)"); ?>'
            },
            {
              id: <?php echo $this->feeds['eDPv']['id']; ?>,
              name: '<?php echo ewatcher_translate("PV energy (kWh)"); ?>'
            },
            {
              id: <?php echo $this->feeds['eDLoadFromPv']['id']; ?>,
              name: '<?php echo ewatcher_translate("PV self-consumed energy (kWh)"); ?>'
            },
            {
              id: <?php echo $this->feeds['eDPvToGrid']['id']; ?>,
              name: '<?php echo ewatcher_translate("PV energy exported to the grid (kWh)"); ?>'
            },
            {
              id: <?php echo $this->feeds['eDGrid']['id']; ?>,
              name: '<?php echo ewatcher_translate("PV energy imported from the grid (kWh)"); ?>'
            }
          ],
          {
            day: "<?php echo ewatcher_translate('Day'); ?>",
            nodata: "<?php echo ewatcher_translate('No data available at the selected date range'); ?>",
            exportcsv: "<?php echo ewatcher_translate('Export to CSV'); ?>",
            total: ""
          });
        });
      </script>
      <?php
    }
  }
?>
