<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 Open HR Group                                     |
// +----------------------------------------------------------------------+
// | Authors: Carsten Bleek <carsten@bleek.de>                            |
// +----------------------------------------------------------------------+
//
// $Id: processEmailResponse.php,v 1.1 2003/03/27 12:36:29 cbleek Exp $
//

/**
* processes the SOAP response of the jobServer send after processing
* the request to activate/deactivate a jobad. This script is executed 
* via procmail. 
* 
* Call this via:
* 
* cat mail.txt | /usr/bin/php processEmailResponse .php
*
* @package  jobAdmin
* @author   Carsten Bleek <carsten@bleek.de>
* @revision $Revision: 1.1 $ 
*/

# include the email server class
require_once dirname(__FILE__).'/../../prepend.inc';
require_once OPENHR_LIB."/Job.php";
require_once 'SOAP/Server/Email.php';

$server = new SOAP_Server_Email;

# read stdin
$fin = fopen('php://stdin','rb');
if (!$fin) exit(0);

$email = '';
while (!feof($fin) && $data = fread($fin, 8096)) {
  $email .= $data;
}

fclose($fin);

# hide show warnings
$oldErrorLevel=error_reporting( E_ALL & ~(E_WARNING | E_NOTICE));

trigger_error("Client received SOAP responce", E_USER_NOTICE);
$response = $server->client($email);
error_reporting($oldErrorLevel);

if (!PEAR::isError($response)){ 
    $job    = &Job::singleton($response->key);
    switch($response->action){
    case JOB_STATUS_ONLINE_REQUESTED:
        $job->_updateStatus( JOB_STATUS_ONLINE ); # murks
        break;
    case JOB_STATUS_OFFLINE_REQUESTED:
        $job->_updateStatus( JOB_STATUS_OFFLINE ); # murks
        break;
    default:
        trigger_error("unknown action $response->action", E_USER_ERROR);
    }
}else{
    var_dump($response);
    trigger_error("an error occured while reading the SOAP response. ".$response->getMessage());
}

?>