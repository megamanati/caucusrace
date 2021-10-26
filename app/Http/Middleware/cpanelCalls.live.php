<?php

namespace App\Http\Middleware;
include("/usr/local/cpanel/php/cpanel.php");

class cPanelAPI extends Middleware
{

 protected function callAPI(){
require_once '/usr/local/cpanel/php/cpanel.php';
require_once 'settings.php';
$cpanel = new CPANEL();
if (strpos($_SERVER['REMOTE_USER'], '@') === false) {
    // cPanel users, give them access to their domains
    $domains_res = $cpanel->uapi('Email', 'list_mail_domains');
    $domains = array();
    foreach ($domains_res['cpanelresult']['result']['data'] as $data) {
        $domains[] = $data['domain'];
    }
    if (empty($domains)) {
        die("No domains");
    }
    $access = array('domain' => $domains);
}
 }
}