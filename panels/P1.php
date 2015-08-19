<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P1 Class
  class EWatcherP1 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 1 View
    public function view() {
      echo "TODO P1";
    }
  }
?>
