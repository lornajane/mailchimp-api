MailChimp API
=============

Super-simple, minimum abstraction MailChimp API 3 wrapper, in PHP.

This lets you get from the MailChimp API docs to the code as directly as possible.

MailChimp API 3 Documentation:

http://developer.mailchimp.com/documentation/mailchimp/reference/overview/

Examples
--------

```php

/**
 * Simple Get User By List ID & Email Example
 */

require_once 'MailChimp.class.php';

$apiKey = 'api-key-here';
$listId = 'list-id-here';

$mc = new MailChimp($apiKey);

// Get all lists
$r = $mc->get('lists');
var_dump($r);

// Get member by email from list by id
$path = sprintf("lists/%s/members/%s", $listId, md5('email@example.com'));
$r = $mc->get($path);
var_dump($r);



