<?php
//
// $Id: processEmailRequest.php,v 1.1 2003/03/27 12:36:29 cbleek Exp $
//

/**
* processes application sent via soap request. Call this script vis
*
* cat msg | processEmailRequest.php 
*
*/

require_once dirname(__FILE__)."/../../prepend.inc";
require_once "/home/carsten/public_html/jobSearch/lib/Application/Server.php";
require_once 'SOAP/Server/Email.php';

$server = new SOAP_Server_Email;
$sc     = new SOAP_jobAdmin();

$server->addObjectMap($sc, 'urn:SOAP_job');

# read stdin
$fin = fopen('php://stdin','rb');
if (!$fin) exit(0);

$email = '';
while (!feof($fin) && $data = fread($fin, 8096)) {
    $email .= $data;
}

fclose($fin);

# workarount
trigger_error("Server received SOAP request", E_USER_NOTICE);
# hide show warnings
$oldErrorLevel=error_reporting( E_ALL & ~(E_WARNING | E_NOTICE));
$server->service($email);
error_reporting($oldErrorLevel);


// Web Services of the jobAdmin module. The jobAdmin Module 
// offers:
// - adding Applications

class SOAP_jobAdmin{

    function addApplication(){
    }

}



?>