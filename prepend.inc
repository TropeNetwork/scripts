<?php

error_reporting(E_ALL);

define ("OPENHR_LIB",dirname(__FILE__)."/../public_html/jobs/lib/");
define ("FILE_INI",  dirname(__FILE__)."/../config/jobAdmin.conf");

# global array containing all configuration options
$OHR_CONFIG=parse_ini_file( FILE_INI );



require_once(OPENHR_LIB."/Logging.php");

?>