<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // P2 Class
  // Consumption - Queries
  class EWatcherP2 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path) {
      parent::__construct($userid, $mysqli, $path);
    }

    // Panel 2 View
    public function view() {
      parent::view();

      // Form: two dates (default to all)
        // Value: tLoad between the dates
        // Table: eDLoad daily between the dates
        // Option to download table as CSV
      echo "TODO P2";
      ?>
      <div data-feedid="603" id="test">
      </div>
                <div id="startDate" class="input-append date control-group">
                    <input data-format="dd/MM/yyyy" value="<?php echo date("d/m/Y", strtotime('-7 days')); ?>" type="text" />
                    <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                </div>
                <div id="endDate" class="input-append date control-group">
                    <input data-format="dd/MM/yyyy" value="<?php echo date("d/m/Y"); ?>" type="text" />
                    <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                </div>
                <label id="testDep"></label>
                <input id="testDep1" type="text" value="1" />
                <input id="testDep2" type="text" value="2" />
                <label id="testDep3">3</label>
                <div id="testTable"></div>
                <script>
                     $(window).ready(function () {
                        $('#startDate').datetimepicker({ pickTime: false });
                        $('#endDate').datetimepicker({ pickTime: false });
                        var test = new CumulativeFeed("#test", "#startDate", "#endDate");
                        var testDep = new DependentValue("#testDep", "#testDep1,#testDep2,#testDep3", function(values) {
                          return values["#testDep1"] + values["#testDep2"] + values["#testDep3"];
                        });

                        var testTable = new FeedDailyTable("#testTable", "#startDate", "#endDate", [
                          {
                            id: 598,
                            name: 'Test name 1'
                          },
                          {
                            id: 603,
                            name: 'Test name 2'
                          }
                        ]);
                      });
                </script>
      <?php
    }
  }
?>
