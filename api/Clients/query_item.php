<?php

namespace CityActivity;

include "DynamoDb.php";

date_default_timezone_set('UTC');

use CityActivity\Clients\DynamoDb;

$dynamodb = new DynamoDb();

$params = [
    'TableName' => 'Venues',
    'KeyConditionExpression' => 'activity_city = :v_id',
    'ExpressionAttributeValues' =>  [
        ':v_id' => ['S' => 'swimming, amsterdam']
    ]
];

$response = $dynamodb->query($params);
print_r($response['Items']);
?>