<?php
  // P5 Class
  // PV - Daily values
  class EWatcherP5 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path, $config) {
      parent::__construct($userid, $mysqli, $path, $config);
    }

    // Panel 5 View
    public function view() {
      parent::view();

      // Graphic: eDPvToGrid, eDLoadFromPv (last 7 days + interactivity), daily graph
      // Graphic: eDPvToGrid, eDGrid (last 7 days + interactivity), daily graph
      // Graphic: eDGrid, eDLoadFromPv (last 7 days + interactivity), daily graph
      // Graphic: eDLoad, eDPv, eDGrid (last 7 days + interactivity), daily graph
      ?>
      <div class="multigraphs">
        <div id="DailyGraph1"><label><?php echo ewatcher_translate("PV energy generated"); ?><label></div>
        <div id="DailyGraph2"><label><?php echo ewatcher_translate("Energy exchanged with the grid"); ?><label></div>
        <div id="DailyGraph3"><label><?php echo ewatcher_translate("Source of the energy consumed"); ?><label></div>
        <div id="DailyGraph4"><label><?php echo ewatcher_translate("Global summary"); ?><label></div>
      </div>
      <script>
        $(window).ready(function() {
          var dailyGraphs = [];
          // Graphic 1
          dailyGraphs.push([
            {
              id: <?php echo $this->feeds['eDLoadFromPv']['id']; ?>,
              color: "#20CA36",
              legend: "<?php echo ewatcher_translate('PV energy self-consumed (kWh)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDPvToGrid']['id']; ?>,
              color: "#DCCC1F",
              legend: "<?php echo ewatcher_translate('PV energy exported to the grid (kWh)'); ?>"
            }
          ]);
          // Graphic 2
          dailyGraphs.push([
            {
              id: <?php echo $this->feeds['eDGrid']['id']; ?>,
              color: "#D52E2E",
              legend: "<?php echo ewatcher_translate('Energy imported from the grid (kWh)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDPvToGrid']['id']; ?>,
              color: "#DCCC1F",
              legend: "<?php echo ewatcher_translate('PV energy exported to the grid (kWh)'); ?>"
            }
          ]);
          // Graphic 3
          dailyGraphs.push([
            {
              id: <?php echo $this->feeds['eDGrid']['id']; ?>,
              color: "#D52E2E",
              legend: "<?php echo ewatcher_translate('Energy imported from the grid (kWh)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDLoadFromPv']['id']; ?>,
              color: "#20CA36",
              legend: "<?php echo ewatcher_translate('PV energy self-consumed (kWh)'); ?>"
            }
          ]);
          // Graphic 4
          dailyGraphs.push([
            {
              id: <?php echo $this->feeds['eDLoad']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Consumption (kWh)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDPv']['id']; ?>,
              color: "#DCCC1F",
              legend: "<?php echo ewatcher_translate('PV energy produced (kWh)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDGrid']['id']; ?>,
              color: "#D52E2E",
              legend: "<?php echo ewatcher_translate('Energy imported from the grid (kWh)'); ?>"
            }
          ]);
          // Load graphs
          for(var i = 1; i <= 4; i++) {
            FeedChartFactory.create("DailyGraph" + i, dailyGraphs[i - 1], {chartType: "daily"});
          }
        });
      </script>
      <?php
    }
  }
?>
