<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // eWatcher controller
  function ewatcher_controller()
  {
    // Global variables
    global $session,$route,$mysqli,$path;

    // Output for the call
    $result = false;

    // Configuration model
    require_once("Modules/ewatcher/EWatcherConfig_model.php");
    $ewatcherconfig = new EWatcherConfig($mysqli, $session["userid"]);

    // View petition
    if ($route->format == "html")
    {
      // Split into actions
      $active = false;
      for($i = 1; (($i <= $ewatcherconfig->numPanels) && ($active === false)); $i++) {
        $panel = "P" . $i;
        if((($route->action == $panel) && ($ewatcherconfig->panels[$panel])) || (($route->action == "") && ($ewatcherconfig->panels[$panel]))) {
          $active = true;
          require_once("Modules/ewatcher/panels/_EWatcherPanel.php");
          require_once("Modules/ewatcher/panels/" . $panel . ".php");
          $className = "EWatcher" . $panel;
          $panelObject = new $className((int)$session['userid'], $mysqli, $path, $ewatcherconfig);
          // Start capturing echo's
          ob_start();
          // Render panel
          $panelObject->view();
          // Get echo's
          $result = ob_get_contents();
          ob_end_clean();
        }
      }
      if(($active === false) || (!$session["write"])) {
        // Start capturing echo's
        ob_start();
        // Render panel
        require_once("Modules/ewatcher/panels/_default.php");
        // Get echo's
        $result = ob_get_contents();
        ob_end_clean();
      }
    }
    // Get/Set settings petition
    else if ($route->format == "json")
    {
      // Cost out
      if (($route->action == "setcout") && ($session["write"])) {
        $result = $ewatcherconfig->setcout(get("cout"));
      }
      // Cost in
      else if (($route->action == "setcin") && ($session["write"])) {
        $result = $ewatcherconfig->setcin(get("cin"));
      }
      // Units
      else if (($route->action == "setunits") && ($session["write"])) {
        $result = $ewatcherconfig->setunits(get("units"));
      }
    }

    // Return content
    return array("content"=>$result, "fullwidth"=>true);
  }
?>
