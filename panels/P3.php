<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P3 Class
  class EWatcherP3 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 3 View
    public function view() {
      echo "TODO P3";
    }
  }
?>
