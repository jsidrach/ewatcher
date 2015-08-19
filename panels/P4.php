<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P4 Class
  class EWatcherP4 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 4 View
    public function view() {
      echo "TODO P4";
    }
  }
?>
