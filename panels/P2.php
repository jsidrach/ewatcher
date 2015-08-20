<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P2 Class
  // Consumption - Queries
  class EWatcherP2 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 2 View
    public function view() {
      // Form: two dates (default to all)
        // Value: tLoad between the dates
        // Table: eDLoad daily between the dates
        // Option to download table as CSV
      echo "TODO P2";
    }
  }
?>
