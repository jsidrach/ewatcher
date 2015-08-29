<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // Translations
  require_once("Modules/ewatcher/ewatcher_translations.php");

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

    // EWatcher configuration
    protected $config;

    // Class constructor
    public function __construct($userid, $mysqli, $path, $config) {
      $this->userid = $userid;
      $this->mysqli = $mysqli;
      $this->path = $path;
      $this->config = $config;

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
        $this->feeds[$feedData->name] = array("id"=>strval($feedData->id), "value"=>round($feedData->value, 2));
      }
    }

    // Panel View
    public function view() {
      // Print global variables, include scripts
      ?>
      <script>
        window.apikey_read = <?php echo "'" . $this->apikey_read . "'"; ?>;
        window.apikey_write = <?php echo "'" . $this->apikey_write . "'"; ?>;
        window.emoncms_path = <?php echo "'" . $this->path . "'"; ?>;
      </script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Lib/flot/jquery.flot.min.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Lib/flot/jquery.flot.time.min.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Lib/flot/jquery.flot.selection.min.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Lib/flot/date.format.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Lib/bootstrap-datetimepicker-0.0.11/js/bootstrap-datetimepicker.min.js"></script>
      <link property="stylesheet" type="text/css" href="<?php echo $this->path; ?>Lib/bootstrap-datetimepicker-0.0.11/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
      <script type="text/javascript" src="<?php echo $this->path; ?>Modules/ewatcher/js/instant-feed.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Modules/ewatcher/js/timeseries.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Modules/ewatcher/js/chart-view.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Modules/ewatcher/js/feed-chart.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Modules/ewatcher/js/cumulative-feed.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Modules/ewatcher/js/dependent-value.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Modules/ewatcher/js/feed-daily-table.js"></script>
      <script type="text/javascript" src="<?php echo $this->path; ?>Modules/ewatcher/js/ewatcher-config-panel.js"></script>
      <link property="stylesheet" type="text/css" href="<?php echo $this->path; ?>Modules/ewatcher/css/style.css" rel="stylesheet">
      <?php
    }
  }
?>
