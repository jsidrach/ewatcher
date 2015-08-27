<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // Global variables
  global $path;

  // Translations
  require_once("Modules/ewatcher/ewatcher_translations.php");

?>
<link type="text/css" href="<?php echo $path; ?>Modules/ewatcher/css/style.css" rel="stylesheet" property="stylesheet">
<div>
  <h2>
    <?php echo ewatcher_translate("This page is not accessible."); ?>
  </h2>
  <h4>
    <?php echo ewatcher_translate("Please contact the administrator to enable/disable the EWatcher panels."); ?>
  </h4>
</div>
