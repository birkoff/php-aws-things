<?php
namespace CityActivity\Clients;

include "DynamoDb.php";

date_default_timezone_set('UTC');

use CityActivity\Clients\DynamoDb;

$dynamodb = new DynamoDb();

$params = [
    'TableName' => 'Venues',
    'KeySchema' => [
        [ 'AttributeName' => 'CityAndActivity', 'KeyType' => 'HASH' ],  //Partition key
        [ 'AttributeName' => 'VenueName', 'KeyType' => 'RANGE' ]  //Sort key
    ],
    'AttributeDefinitions' => [
        [ 'AttributeName' => 'CityAndActivity', 'AttributeType' => 'S' ],
        [ 'AttributeName' => 'CityAndCategory', 'AttributeType' => 'S' ],
        [ 'AttributeName' => 'VenueName', 'AttributeType' => 'S' ],
        [ 'AttributeName' => 'Category', 'AttributeType' => 'S' ],
        [ 'AttributeName' => 'Activity', 'AttributeType' => 'S' ],
    ],
    'LocalSecondaryIndexes' => [
        [
            'IndexName' => 'CityAndActivityPerCategory',
            'KeySchema' => [
                ['AttributeName' => 'CityAndActivity', 'KeyType' => 'HASH'],
                ['AttributeName' => 'Category', 'KeyType' => 'RANGE'],
            ],
            'Projection' => ['ProjectionType' => 'KEYS_ONLY'],
        ],
    ],
    'GlobalSecondaryIndexes' => [
        [
            'IndexName' => 'CityAndCategory',
            'ProvisionedThroughput' => [
                'ReadCapacityUnits' => 1,
                'WriteCapacityUnits' => 1
            ],
            'KeySchema' => [
                ['AttributeName' => 'CityAndCategory', 'KeyType' => 'HASH'],
                ['AttributeName' => 'Activity', 'KeyType' => 'RANGE'],
            ],
            'Projection' => ['ProjectionType' => 'ALL'],
        ],
    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 1,
        'WriteCapacityUnits' => 1
    ]
];

$dynamodb->createTable($params);

?>