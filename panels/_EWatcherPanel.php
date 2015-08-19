<?php
  // No direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  // Panel class
  abstract class EWatcherPanel
  {
    // User id
    protected $userid;

    // Database connection
    protected $mysqli;

    // Read API key
    protected $apikey_read;

    // Write API key
    protected $apikey_write;

    // Feed ids and last values
    protected $feeds;

    // Class constructor
    public function __construct($userid, $mysqli) {
      $this->userid = $userid;
      $this->mysqli = $mysqli;

      // Get API keys
      $userid = intval($userid);
      $result = $this->mysqli->query("SELECT * FROM users WHERE `id`='$this->userid'");
      $userData = $result->fetch_object();
      $this->apikey_read = $userData->apikey_read;
      $this->apikey_write = $userData->apikey_write;

      // Get all feed ids and last values
      $this->feeds = array();
      $result = $this->mysqli->query("SELECT * FROM feeds WHERE `userid`='$this->userid'");
      while($feedData = $result->fetch_object()) {
        $this->feeds[$feedData->name] = array("id"=>$feedData->id, "value"=>$feedData->value);
      }
    }

    // Panel View
    abstract public function view();
  }
?>
