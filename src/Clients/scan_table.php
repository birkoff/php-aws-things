<?php

namespace leisureManager;

include "DynamoDb.php";

date_default_timezone_set('UTC');

use leisureManager\Clients\DynamoDb;

$dynamodb = new DynamoDb();

$response = $dynamodb->scan('Venues');

print_r($response);

//foreach ($response['Items'] as $key => $value) {
//    echo 'Id: ' . $value['Id']['S'] . "\n";
//    echo 'ReplyDateTime: ' . $value['ReplyDateTime']['S'] . "\n";
//    echo 'Message: ' . $value['Message']['S'] . "\n";
//    echo 'PostedBy: ' . $value['PostedBy']['S'] . "\n";
//    echo "\n";
//}