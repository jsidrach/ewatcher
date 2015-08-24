<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // P4 Class
  // PV - Queries
  class EWatcherP4 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path) {
      parent::__construct($userid, $mysqli, $path);
    }

    // Panel 4 View
    public function view() {
      parent::view();

      // (Optional) set: cIn, cOut, units
      // Form: two dates (default to all)
        // Value: tLoad, tPv, tPvToLoad, tPvToNet, tLoadFromNet, 100*tPvToLoad/tPv, 100*tPvToLoad/tLoad
        // Value (from retrieved values): cNet, cPvToNet, cLoadNoPv, cLoadPv, savings
        // Table: eDLoad, eDPv, eDLoadFromPv, eDPvToNet, eDNet (daily between the dates)
        // Option to download table as csv
      echo "TODO P4";
    }
  }
?>
