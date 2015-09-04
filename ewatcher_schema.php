<?php
  // eWatcher table schema
  $schema['ewatcher'] = array(
    "userid" => array("type" => "int(11)", "Null" => "NO"),
    "P1" => array("type" => "tinyint(1)", "Null" => "NO", "default" => 0),
    "P2" => array("type" => "tinyint(1)", "Null" => "NO", "default" => 0),
    "P3" => array("type" => "tinyint(1)", "Null" => "NO", "default" => 0),
    "P4" => array("type" => "tinyint(1)", "Null" => "NO", "default" => 0),
    "P5" => array("type" => "tinyint(1)", "Null" => "NO", "default" => 0),
    "cIn" => array("type" => "float", "Null" => "NO", "default" => 0.1244),
    "cOut" => array("type" => "float", "Null" => "NO", "default" => 0.054),
    "units" => array("type" => "char(8)", "Null" => "NO", "default" => "€")
  );
?>
