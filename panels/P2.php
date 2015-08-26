<?php
  // P2 Class
  // Consumption - Queries
  class EWatcherP2 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path, $config) {
      parent::__construct($userid, $mysqli, $path, $config);
    }

    // Panel 2 View
    public function view() {
      parent::view();

      // Form: two dates (default to one week)
        // Value: tLoad between the dates (cumulative feed)
        // Table: eDLoad daily between the dates (daily table)
      ?>
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
        <div class="multiple-values multiple-1">
          <span class="single-value">
            <label><?php echo ewatcher_translate("Energy consumption"); ?></label>
            <span id="tLoad" data-feedid="<?php echo $this->feeds['tLoad']['id']; ?>">
            </span>
            <span>kWh</span>
          </span>
        </div>
      </div>
      <div class="daily-values" id="eDLoad"></div>
      <script>
        $(window).ready(function () {
          $('#startDate').datetimepicker({ pickTime: false });
          $('#endDate').datetimepicker({ pickTime: false });
          var tLoad = new CumulativeFeed("#tLoad", "#startDate", "#endDate");
          var dailyTable = new FeedDailyTable("#eDLoad", "#startDate", "#endDate", [
            {
              id: <?php echo $this->feeds['eDLoad']['id']; ?>,
              name: 'Daily energy consumption (kWh/d)'
            }
          ]);
        });
      </script>
      <?php
    }
  }
?>
