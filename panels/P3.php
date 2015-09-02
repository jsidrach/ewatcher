<?php
  // P3 Class
  // PV
  class EWatcherP3 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path, $config) {
      parent::__construct($userid, $mysqli, $path, $config);
    }

    // Panel 3 View
    public function view() {
      parent::view();

    // Value: sPLoad, sPPv, iGridToLoad, iPvToGrid (instant feeds)
    // Graphic: sPLoad, sPPv, iGridToLoad (continuous graph)
    // Value: eDPv, eDLoadFromPv, eDPvToGrid, eDGrid, eDLoad (instant feeds)
    // Value: dPLoadFromPv, dPSelf (intant feeds)
    ?>
    <div class="multiple-values-container">
      <div class="multiple-values multiple-3">
        <span class="single-value">
          <label><?php echo ewatcher_translate("PV produced power"); ?></label>
          <span id="sPPv" class="ewatcher-yellow instant-feed" data-feedid="<?php echo $this->feeds['sPPv']['id']; ?>">
            <?php echo $this->feeds['sPPv']['value']; ?>
          </span>
          <span class="ewatcher-yellow">W</span>
        </span>
        <span class="single-value">
          <label><?php echo ewatcher_translate("Consumption"); ?></label>
          <span id="sPLoad" class="instant-feed" data-feedid="<?php echo $this->feeds['sPLoad']['id']; ?>">
            <?php echo $this->feeds['sPLoad']['value']; ?>
          </span>
          <span>W</span>
        </span>
        <span class="single-value">
          <label><?php echo ewatcher_translate("PV power exported to the grid"); ?></label>
          <span id="iPvToGrid" class="ewatcher-green"></span>
          <span class="ewatcher-green">W</span>
        </span>
      </div>
    </div>
    <div class="multiple-values-container">
      <div class="multiple-values multiple-1">
        <span class="single-value">
          <label><?php echo ewatcher_translate("Consumption from the grid"); ?></label>
          <span id="iGridToLoad" class="ewatcher-red"></span>
          <span class="ewatcher-red">W</span>
        </span>
      </div>
    </div>
    <div class="multigraphs">
      <div id="P3Graph1"></div>
      <div id="P3Graph2"></div>
    </div>
    <div class="title-separator">
      <h3><?php echo ewatcher_translate("Today's energy values"); ?> - <?php echo date("d/m/Y"); ?></h3>
    </div>
    <div class="multiple-values-container">
      <div class="multiple-values multiple-2">
        <span class="single-value">
          <label><?php echo ewatcher_translate("PV produced energy"); ?></label>
          <span class="ewatcher-yellow instant-feed" data-feedid="<?php echo $this->feeds['eDPv']['id']; ?>">
            <?php echo $this->feeds['eDPv']['value']; ?>
          </span>
          <span class="ewatcher-yellow">kWh</span>
        </span>
        <span class="single-value">
          <label><?php echo ewatcher_translate("PV self-consumed energy"); ?></label>
          <span class="ewatcher-yellow instant-feed" data-feedid="<?php echo $this->feeds['eDLoadFromPv']['id']; ?>">
            <?php echo $this->feeds['eDLoadFromPv']['value']; ?>
          </span>
          <span class="ewatcher-yellow">kWh</span>
        </span>
      </div>
    </div>
    <div class="multiple-values-container">
      <div class="multiple-values multiple-3">
        <span class="single-value">
          <label><?php echo ewatcher_translate("PV energy exported to the grid"); ?></label>
          <span class="ewatcher-green instant-feed" data-feedid="<?php echo $this->feeds['eDPvToGrid']['id']; ?>">
            <?php echo $this->feeds['eDPvToGrid']['value']; ?>
          </span>
          <span class="ewatcher-green">kWh</span>
        </span>
        <span class="single-value">
          <label><?php echo ewatcher_translate("Energy imported from the grid"); ?></label>
          <span class="ewatcher-red instant-feed" data-feedid="<?php echo $this->feeds['eDGrid']['id']; ?>">
            <?php echo $this->feeds['eDGrid']['value']; ?>
          </span>
          <span class="ewatcher-red">kWh</span>
        </span>
        <span class="single-value">
          <label><?php echo ewatcher_translate("Consumption"); ?></label>
          <span class="instant-feed" data-feedid="<?php echo $this->feeds['eDLoad']['id']; ?>">
            <?php echo $this->feeds['eDLoad']['value']; ?>
          </span>
          <span>kWh</span>
        </span>
      </div>
    </div>
    <div class="multiple-values-container">
      <div class="multiple-values multiple-2">
        <span title="<?php echo ewatcher_translate('Self-consumed energy relative to the total load'); ?>" class="single-value">
          <label><?php echo ewatcher_translate("Self-sufficiency"); ?></label>
          <span class="ewatcher-yellow instant-feed" data-feedid="<?php echo $this->feeds['dPLoadFromPv']['id']; ?>">
            <?php echo $this->feeds['dPLoadFromPv']['value']; ?>
          </span>
          <span class="ewatcher-yellow">%</span>
        </span>
        <span title="<?php echo ewatcher_translate('Self-consumed energy relative to the total PV energy produced'); ?>" class="single-value">
          <label><?php echo ewatcher_translate("Self-consumption"); ?></label>
          <span class="ewatcher-green instant-feed" data-feedid="<?php echo $this->feeds['dPSelf']['id']; ?>">
            <?php echo $this->feeds['dPSelf']['value']; ?>
          </span>
          <span class="ewatcher-green">%</span>
        </span>
      </div>
    </div>
    <script>
      $(window).ready(function() {
        // iGridToLoad value
        var iGridToLoad = new DependentValue("#iGridToLoad", "#sPPv,#sPLoad", function(values) {
          var sPPv = parseFloat(values["#sPPv"]);
          var sPLoad = parseFloat(values["#sPLoad"]);
          var res = sPLoad - sPPv;
          if(res < 0) {
            res = 0;
          }
          return Math.round(res * 100) / 100;
        });
        // iPvToGrid value
        var iPvToGrid = new DependentValue("#iPvToGrid", "#sPPv,#sPLoad", function(values) {
          var sPPv = parseFloat(values["#sPPv"]);
          var sPLoad = parseFloat(values["#sPLoad"]);
          var res = sPPv - sPLoad;
          if(res < 0) {
            res = 0;
          }
          return Math.round(res * 100) / 100;
        });
        // P3 Graph 1
        var P3Graph1 = [
          {
            id: <?php echo $this->feeds['sPLoad']['id']; ?>,
            color: "#0699FA",
            legend: "<?php echo ewatcher_translate('Consumption (W)'); ?>",
            fill: 0,
            line: 1.5
          },
          {
            id: <?php echo $this->feeds['iPvToGrid']['id']; ?>,
            color: "#20CA36",
            legend: "<?php echo ewatcher_translate('PV power exported to the grid (W)'); ?>",
            fill: 0,
            line: 1.5
          }
        ];
        FeedChartFactory.create("P3Graph1", P3Graph1, {defaultRange: 1, steps: false});
        // P3 Graph 2
        var P3Graph2 = [
          {
            id: <?php echo $this->feeds['sPPv']['id']; ?>,
            color: "#DCCC1F",
            legend: "<?php echo ewatcher_translate('PV produced power (W)'); ?>",
            fill: 0,
            line: 1.5
          },
          {
            id: <?php echo $this->feeds['iGridToLoad']['id']; ?>,
            color: "#D52E2E",
            legend: "<?php echo ewatcher_translate('Consumption from the grid (W)'); ?>",
            fill: 0,
            line: 1.5
          }
        ];
        FeedChartFactory.create("P3Graph2", P3Graph2, {defaultRange: 1, steps: false});
      });
    </script>
    <?php
    }
  }
?>
