<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 Open HR Group                                     |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Authors: Carsten Bleek <carsten@bleek.de>                            |
// +----------------------------------------------------------------------+
//
// $Id: emailClient.php,v 1.4 2003/03/13 11:26:18 cbleek Exp $
//

/*
This reads a message from stdin, and calls the soap server defined

You file should be executed by procmail

    | /usr/bin/php Client/emailServer.php
*/

# include the email server class
require_once dirname(__FILE__).'/../prepend.inc';
require_once 'SOAP/Server/Email.php';
require_once OPENHR_LIB."/Job.php";
$server = new SOAP_Server_Email;

# read stdin
$fin = fopen('php://stdin','rb');
if (!$fin) exit(0);

$email = '';
while (!feof($fin) && $data = fread($fin, 8096)) {
  $email .= $data;
}

fclose($fin);


$response = $server->client($email);

if (!PEAR::isError($response)){ 
    $job    = &Job::singleton($response->key);
    switch($response->action){
    case JOB_STATUS_ONLINE_REQUEST:
        $job->_updateStatus( JOB_STATUS_ONLINE ); # murks
        break;
    case JOB_STATUS_OFFLINE_REQUEST:
        $job->_updateStatus( JOB_STATUS_OFFLINE ); # murks
        break;
    default:
        trigger_error("unknown action $response->action");
    }
}else{
    trigger_error("an error occured while reading the SOAP response");
}

?>