<?php
//
// $Id: emailServer.php,v 1.2 2003/03/13 07:46:35 cbleek Exp $
//

/*
This reads a message from stdin, and calls the soap server defined

You can use this from qmail by creating a .qmail-soaptest file with:
    | /usr/bin/php /path/to/email_server.php
*/

require_once "../prepend.inc";
require_once "/home/carsten/public_html/jobSearch/lib/SearchIndex.php";

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
$server->service($email);

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