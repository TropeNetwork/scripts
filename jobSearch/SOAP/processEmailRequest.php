<?php
//
// $Id: processEmailRequest.php,v 1.2 2003/04/07 11:57:07 cbleek Exp $
//

/*
This reads a message from stdin, and calls the soap server defined

You can use this from qmail by creating a .qmail-soaptest file with:
    | /usr/bin/php /path/to/email_server.php
*/

require_once dirname(__FILE__)."/../../prepend.inc";
require_once OPENHR_LIB."/SearchIndex.php";

# include the email server class
require_once 'SOAP/Server/Email.php';

$server = new SOAP_Server_Email;

$sc     = new SOAP_job();

$server->addObjectMap($sc, 'urn:SOAP_job');

# read stdin
$fin = fopen('php://stdin','rb');
if (!$fin) exit(0);

$email = '';
while (!feof($fin) && $data = fread($fin, 8096)) {
    $email .= $data;
}

fclose($fin);

# doit!
trigger_error("Server received SOAP request", E_USER_NOTICE);
# hide show warnings
$oldErrorLevel=error_reporting( E_ALL & ~(E_WARNING | E_NOTICE));
$server->service($email);
error_reporting($oldErrorLevel);



// Sample SOAP Class. WILL BE COMPLETELY CHANGED
// Because adding and removing
// jobs from search engines may take a certain time, the SOAP
// interface will use SMTP as the transport protocoll.

class SOAP_job{
    /**
     * add job into index
     */
    function activate($job_id, $data){
        $index=new SearchIndex;

        return $index->insert($job_id, $data);
    }

    /**
     * remove job from index
     */
    function deactivate($job_id){
        $index=new SearchIndex;
        return $index->delete($job_id);
    }
}



?>