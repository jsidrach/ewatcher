<?php
  // No direct access
  defined("EMONCMS_EXEC") or die("Restricted access");

  // Translations
  require_once("Modules/ewatcher/ewatcher_translations.php");

  // Default generic page (error, no panel available for this user)
  echo 'TODO - Default';

  echo ewatcher_translate('Hola');
?>
