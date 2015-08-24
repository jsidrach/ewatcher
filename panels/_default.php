<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // Translations
  require_once("Modules/ewatcher/ewatcher_translations.php");

  // Default generic page (error, no panel available for this user)
  $error_string = ewatcher_translate("There has been an error. The page is not accessible.");
  $panels_string = ewatcher_translate("Please contact the administrator to enable/disable the eWatcher panels.");



  echo "<p> ".$error_string."\n </p>";
  echo "<p> ".$panels_string."\n </p>";
?>
