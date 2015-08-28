<?php
  // Translate a string (in ewatcher catalog)
  function ewatcher_translate($string) {
    $ewatcher_domain = "messages";
    bindtextdomain($ewatcher_domain, "Modules/ewatcher/locale");
    bind_textdomain_codeset($ewatcher_domain, "UTF-8");
    return dgettext($ewatcher_domain, $string);
  }
?>
