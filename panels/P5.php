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

      // Graphic: eDPvToNet, eDLoadFromPv (last 7 days + interactivity), daily graph
      // Graphic: eDPvToNet, eDNet (last 7 days + interactivity), daily graph
      // Graphic: eDNet, eDLoadFromPv (last 7 days + interactivity), daily graph
      // Graphic: eDLoad, eDPv, eDNet (last 7 days + interactivity), daily graph
      ?>
      <div class="multigraphs">
        <div id="DailyGraph1"></div>
        <div id="DailyGraph2"></div>
        <div id="DailyGraph3"></div>
        <div id="DailyGraph4"></div>
      </div>
      <script>
        $(window).ready(function() {
          var dailyGraphs = [];
          // Graphic 1
          dailyGraphs.push([
            {
              id: <?php echo $this->feeds['eDPvToNet']['id']; ?>,
              color: "#DCCC1F",
              legend: "<?php echo ewatcher_translate('PV energy exported to the grid (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDLoadFromPv']['id']; ?>,
              color: "#20CA36",
              legend: "<?php echo ewatcher_translate('PV energy self-consumed (kWh/d)'); ?>"
            }
          ]);
          // Graphic 2
          dailyGraphs.push([
            {
              id: <?php echo $this->feeds['eDPvToNet']['id']; ?>,
              color: "#DCCC1F",
              legend: "<?php echo ewatcher_translate('PV exported to the grid (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDNet']['id']; ?>,
              color: "#D52E2E",
              legend: "<?php echo ewatcher_translate('Energy imported from the grid (kWh/d)'); ?>"
            }
          ]);
          // Graphic 3
          dailyGraphs.push([
            {
              id: <?php echo $this->feeds['eDNet']['id']; ?>,
              color: "#D52E2E",
              legend: "<?php echo ewatcher_translate('Energy imported from the grid (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDLoadFromPv']['id']; ?>,
              color: "#20CA36",
              legend: "<?php echo ewatcher_translate('PV energy self-consumed (kWh/d)'); ?>"
            }
          ]);
          // Graphic 4
          dailyGraphs.push([
            {
              id: <?php echo $this->feeds['eDLoad']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Consumption (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDPv']['id']; ?>,
              color: "#DCCC1F",
              legend: "<?php echo ewatcher_translate('PV energy produced (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDNet']['id']; ?>,
              color: "#D52E2E",
              legend: "<?php echo ewatcher_translate('Energy imported from the grid (kWh/d)'); ?>"
            }
          ]);
          // Load graphs
          for(var i = 1; i <= 4; i++) {
            FeedChartFactory.create("DailyGraph" + i, dailyGraphs[i - 1], {chartType: "daily", pWidth: 1, controls: true});
          }
        });
      </script>
      <?php
    }
  }
?>
