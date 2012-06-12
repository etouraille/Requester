<?php

ini_set('display_errors', 1);
require_once dirname(__FILE__) . '/../src/Requester/Requester.php';

$proxy = array(
    'url' => 'http://proxy.corp.something:3128'
);

$proxy_ntlm = array(
    'url' => 'http://proxy.corp.something:8080',
    'auth' => 'some_user:somepass',
    'auth_method' => 'NTLM',
);

$proxy_basic = array(
    'url' => 'http://proxy.corp.something:3128',
    'auth' => 'user:pass',
);

define('BASE_URL', 'http://httpbin.org');