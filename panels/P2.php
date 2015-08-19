<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P2 Class
  class EWatcherP2 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 2 View
    public function view() {
      echo "TODO P2";
    }
  }
?>
