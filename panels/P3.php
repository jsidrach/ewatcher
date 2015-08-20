<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // P3 Class
  // PV
  class EWatcherP3 extends EWatcherPanel {
    // Constructor
    function __construct($userid, $mysqli, $path) {
      parent::__construct($userid, $mysqli, $path);
    }

    // Panel 3 View
    public function view() {
      parent::view();

      // Value: sPLoad, sPPv, iGridToLoad
      // Graphic: sPLoad, sPPv, iGridToLoad (last 7 days + interactivity)
      // Value: eDPv, eDLoadFromPv, eDPvToNet, eDNet
      // Value: dPLoadFromPv, dPSelf
      echo "TODO P3";
    }
  }
?>
