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
      // Graphic: eDPvToNet, eDLoadFromPv, eDNet (last 7 days + interactivity)
      // Graphic: eDNet, eDLoadFromPv (last 7 days + interactivity)
      // Graphic: eDLoad, eDPv, eDNet (last 7 days + interactivity)
      
      ?>
      <div id="graph_1"></div>
      <script>
        $(window).ready(function() {
          // sPLoad graphic
          var graph_1 = [
            {
              id: <?php echo $this->feeds['eDPvToNet']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('PV energy injected itno the net (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDLoadFromPv']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Self-consumed PV energy (kWh/d)'); ?>"
            }
          ];
          FeedChartFactory.create("graph_1", graph_1, {chartType: "daily"});
        });
      </script>
      <div id="graph_4"></div>
      <script>
        $(window).ready(function() {
          // sPLoad graphic
          var graph_4 = [
            {
              id: <?php echo $this->feeds['eDPvToNet']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('PV energy injected itno the net (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDNet']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Energy imported from the net (kWh/d)'); ?>"
            }
          ];
          FeedChartFactory.create("graph_4", graph_4, {chartType: "daily"});
        });
      </script>
      <div id="graph_2"></div>
      <script>
        $(window).ready(function() {
          // sPLoad graphic
          var graph_2 = [
            {
              id: <?php echo $this->feeds['eDNet']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Energy imported from the net (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDLoadFromPv']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Self-consumed PV energy (kWh/d)'); ?>"
            }
          ];
          FeedChartFactory.create("graph_2", graph_2, {chartType: "daily"});
        });
      </script>
      <div id="graph_3"></div>
      <script>
        $(window).ready(function() {
          // sPLoad graphic
          var graph_3 = [
            {
              id: <?php echo $this->feeds['eDLoad']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Consumption (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDPv']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('PV energy (kWh/d)'); ?>"
            },
            {
              id: <?php echo $this->feeds['eDNet']['id']; ?>,
              color: "#0699FA",
              legend: "<?php echo ewatcher_translate('Energy imported from the net (kWh/d)'); ?>"
            }
          ];
          FeedChartFactory.create("graph_3", graph_3, {chartType: "daily"});
        });
      </script>
      <?php
    }
  }
?>
