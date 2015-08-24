<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // EWatcher module configuration
  class EWatcherConfig
  {
    // Database connection
    private $mysqli;
    // User id
    private $userid;
    // Number of panels
    public $numPanels;
    // Name of the panels
    public $panelsNames;
    // Panels active
    public $panels;

    // Class constructor
    public function __construct($mysqli, $userid)
    {
      $this->mysqli = $mysqli;
      $this->userid = (int) $userid;

      // Set configuration
      $this->numPanels = 5;
      $this->panelsNames = array(
        "P1"=>_("Consumption"),
        "P2"=>_("Consumption - Queries"),
        "P3"=>_("PV"),
        "P4"=>_("PV - Queries"),
        "P5"=>_("PV - Daily values")
      );

      // Asign panel actives
      $result = $mysqli->query("SELECT * FROM ewatcher WHERE userid=$this->userid;");
      if(($result === FALSE) || (empty($result)) || ($result->num_rows == 0)) {
        // Create ewatcher user config if it does not exist
        if($mysqli->query("INSERT INTO ewatcher (userid) VALUES ($userid);") === FALSE) {
          return;
        }
        $result = $mysqli->query("SELECT * FROM ewatcher WHERE userid=$this->userid;");
      }
      $result = $result->fetch_object();
      for($i = 1; $i <= $this->numPanels; $i++) {
        $panelName = "P" . $i;
        $this->panels[$panelName] = ($result->$panelName == 1) ? true : false;
      }
    }

    // Get output cost
    public function getcout() {
      return $this->getProperty("cOut");
    }

    // Get income cost
    public function getcin() {
      return $this->getProperty("cIn");
    }

    // Get units
    public function getunits() {
      $this->mysqli->set_charset("utf8");
      return $this->getProperty("units");
    }

    // Get generic property
    private function getProperty($name) {
      $result = $mysqli->query("SELECT * FROM ewatcher WHERE userid=$this->userid;");
      if($result->num_rows == 0) {
        return false;
      }
      return $result->fetch_object()->$name;
    }

    // Set output cost
    public function setcout($value) {
      return $this->setProperty("cOut", (float) $value);
    }

    // Set income cost
    public function setcin($value) {
      return $this->setProperty("cIn", (float) $value);
    }

    // Set units
    public function setunits($value) {
      return $this->setProperty("units", "'" . $this->mysqli->real_escape_string($value) . "'");
    }

    // Set generic property
    private function setProperty($name, $value) {
      $this->mysqli->set_charset("utf8");
      if($this->mysqli->query("UPDATE ewatcher SET $name=$value WHERE userid=$userid;") === FALSE) {
        return false;
      }
      return true;
    }
  }
?>
