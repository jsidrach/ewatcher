<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P1 Class
  // Consumption
  class EWatcherP1 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli) {
      parent::__construct($userid, $mysqli);
    }

    // Panel 1 View
    public function view() {
      // Value: sPLoad, sVoltage
      // Graphic: sPLoad (last 7 values + interactivity)
      // Value: eDLoad
      // Graphic: eDLoad (last 7 values + interactivity)
      echo "TODO P1";
    }
  }
?>
