<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // P5 Class
  // PV - Daily values
  class EWatcherP5 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path) {
      parent::__construct($userid, $mysqli, $path);
    }

    // Panel 5 View
    public function view() {
      parent::view();

      // Graphic: eDPvToNet, eDLoadFromPv, eDNet (last 7 days + interactivity)
      // Graphic: eDNet, eDLoadFromPv (last 7 days + interactivity)
      // Graphic: eDLoad, eDPv, eDNet (last 7 days + interactivity)
      echo "TODO P5";
    }
  }
?>
