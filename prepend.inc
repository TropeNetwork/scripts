<?php

error_reporting(E_ALL);



# global array containing all configuration options
$OHR_CONFIG=parse_ini_file( $_ENV['OHR_CONFIG_FILE'] );

define ("OPENHR_LIB",$OHR_CONFIG["dir.base_openhr"]."/lib/");


require_once(OPENHR_LIB."/Logging.php");

?>