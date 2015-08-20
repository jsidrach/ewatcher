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

    // Server path
    protected $path;

    // Read API key
    protected $apikey_read;

    // Write API key
    protected $apikey_write;

    // Feed ids and last values
    protected $feeds;

    // Class constructor
    public function __construct($userid, $mysqli, $path) {
      $this->userid = $userid;
      $this->mysqli = $mysqli;
      $this->path = $path;

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
    public function view() {
      // Print global variables, include scripts
      ?>
      <script>
        window.apikey_read = <?php echo "'" . $this->apikey_read . "'"; ?>;
        window.emoncms_path = <?php echo "'" . $this->path . "'"; ?>;
      </script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Modules/ewatcher/js/instant-feed.js"></script>
      <?php
    }
  }
?>
