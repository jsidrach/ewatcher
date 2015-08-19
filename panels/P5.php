<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P5 Class
  class EWatcherP5 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 5 View
    public function view() {
      echo "TODO P5";
    }
  }
?>
