<?php

error_reporting(E_ALL);


define ("FILE_INI",  dirname(__FILE__)."/../config/OpenHR.conf");

# global array containing all configuration options
$OHR_CONFIG=parse_ini_file( FILE_INI );

define ("OPENHR_LIB",$OHR_CONFIG["dir.base_openhr"]."/lib/");


require_once(OPENHR_LIB."/Logging.php");

?>