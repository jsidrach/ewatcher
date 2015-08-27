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

    // Value: sPLoad, sPPv, iGridToLoad, iPvToNet (instant feeds)
    // Graphic: sPLoad, sPPv, iGridToLoad (continuous graph)
    // Value: eDPv, eDLoadFromPv, eDPvToNet, eDNet, eDLoad (instant feeds)
    // Value: dPLoadFromPv, dPSelf (intant feeds)
    ?>
    <div class="multiple-values-container">
      <div class="multiple-values multiple-3">
        <span class="single-value">
          <label><?php echo ewatcher_translate("PV produced power"); ?></label>
          <span class="ewatcher-yellow instant-feed" data-feedid="<?php echo $this->feeds['sPPv']['id']; ?>">
            <?php echo $this->feeds['sPPv']['value']; ?>
          </span>
          <span class="ewatcher-yellow">W</span>
        </span>
        <span class="single-value">
          <label><?php echo ewatcher_translate("Consumption"); ?></label>
          <span class="instant-feed" data-feedid="<?php echo $this->feeds['sPLoad']['id']; ?>">
            <?php echo $this->feeds['sPLoad']['value']; ?>
          </span>
          <span>W</span>
        </span>
        <span class="single-value">
          <label><?php echo ewatcher_translate("PV power exported to the grid"); ?></label>
          <span class="ewatcher-yellow instant-feed" data-feedid="<?php echo $this->feeds['iPvToNet']['id']; ?>">
            <?php echo $this->feeds['iPvToNet']['value']; ?>
          </span>
          <span class="ewatcher-yellow">W</span>
        </span>
      </div>
    </div>
    <div class="multiple-values-container">
      <div class="multiple-values multiple-1">
        <span class="single-value">
          <label><?php echo ewatcher_translate("Consumption from grid"); ?></label>
          <span class="ewatcher-red instant-feed" data-feedid="<?php echo $this->feeds['iGridToLoad']['id']; ?>">
            <?php echo $this->feeds['iGridToLoad']['value']; ?>
          </span>
          <span class="ewatcher-red">W</span>
        </span>
      </div>
    </div>
    <div id="P3Graph"></div>
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
          <span class="ewatcher-yellow instant-feed" data-feedid="<?php echo $this->feeds['eDPvToNet']['id']; ?>">
            <?php echo $this->feeds['eDPvToNet']['value']; ?>
          </span>
          <span class="ewatcher-yellow">kWh</span>
        </span>
        <span class="single-value">
          <label><?php echo ewatcher_translate("Energy imported from the grid"); ?></label>
          <span class="ewatcher-red instant-feed" data-feedid="<?php echo $this->feeds['eDNet']['id']; ?>">
            <?php echo $this->feeds['eDNet']['value']; ?>
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
        <span class="single-value">
          <label><?php echo ewatcher_translate("Self-sufficiency"); ?></label>
          <span class="ewatcher-yellow instant-feed" data-feedid="<?php echo $this->feeds['dPLoadFromPv']['id']; ?>">
            <?php echo $this->feeds['dPLoadFromPv']['value']; ?>
          </span>
          <span class="ewatcher-yellow">%</span>
        </span>
        <span class="single-value">
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
        // P3 Graph
        var P3Graph = [
          {
            id: <?php echo $this->feeds['sPLoad']['id']; ?>,
            color: "#0699FA",
            legend: "<?php echo ewatcher_translate('Consumption (W)'); ?>",
            fill: 0,
            line: 1
          },
          {
            id: <?php echo $this->feeds['sPPv']['id']; ?>,
            color: "#DCCC1F",
            legend: "<?php echo ewatcher_translate('PV produced power (W)'); ?>",
            fill: 0,
            line: 1
          },
          {
            id: <?php echo $this->feeds['iGridToLoad']['id']; ?>,
            color: "#D52E2E",
            legend: "<?php echo ewatcher_translate('Consumption from grid (W)'); ?>",
            fill: 0,
            line: 1
          },
          {
            id: <?php echo $this->feeds['iPvToNet']['id']; ?>,
            color: "#20CA36",
            legend: "<?php echo ewatcher_translate('PW power exported to the grid (W)'); ?>",
            fill: 0,
            line: 1
          }
        ];
        FeedChartFactory.create("P3Graph", P3Graph, {defaultRange: 1});
      });
    </script>
    <?php
    }
  }
?>
