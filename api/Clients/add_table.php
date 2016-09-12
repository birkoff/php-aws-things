<?php
namespace CityActivity;

include "DynamoDb.php";

date_default_timezone_set('UTC');

use CityActivity\Clients\DynamoDb;

$dynamodb = new DynamoDb();

$params = [
    'TableName' => 'Venues',
    'KeySchema' => [
        [ 'AttributeName' => 'activity_city', 'KeyType' => 'HASH' ],  //Partition key
        [ 'AttributeName' => 'name', 'KeyType' => 'RANGE' ]  //Sort key
    ],
    'AttributeDefinitions' => [
        [ 'AttributeName' => 'activity_city', 'AttributeType' => 'S' ],
        [ 'AttributeName' => 'name', 'AttributeType' => 'S' ]
    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 5,
        'WriteCapacityUnits' => 5
    ]
];

$dynamodb->createTable($params);

?>