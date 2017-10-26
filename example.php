<?php

/**
 * Simple Get User By List ID & Email Example
 */

require_once 'MailChimp.class.php';

$apiKey = 'api-key-here';
$listId = 'list-id-here';

$mc = new MailChimp($apiKey);

$path = sprintf("lists/%s/members/%s", $listId, md5('email@example.com'));
$r = $mc->get($path);
var_dump($r);


