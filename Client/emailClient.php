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
// $Id: emailClient.php,v 1.3 2003/03/13 08:33:41 cbleek Exp $
//

/*
This reads a message from stdin, and calls the soap server defined

You file should be executed by procmail

    | /usr/bin/php Client/emailServer.php
*/

# include the email server class
require_once '../prepend.inc';
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

var_dump($response);

?>