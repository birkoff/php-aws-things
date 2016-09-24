<?php

namespace CityActivity;

include "DynamoDb.php";

date_default_timezone_set('UTC');

use CityActivity\Clients\DynamoDb;

$dynamodb = new DynamoDb();

/*
 * "ExpressionAttributeValues": {
      "string" : {
         "B": blob,
         "BOOL": boolean,
         "BS": [ blob ],
         "L": [
            "AttributeValue"
         ],
         "M": {
            "string" : "AttributeValue"
         },
         "N": "string",
         "NS": [ "string" ],
         "NULL": boolean,
         "S": "string",
         "SS": [ "string" ]
      }
   },
 */
$params_GSI = [
    'TableName' => 'Venues',
    'IndexName' => 'CityAndCategory',
    "ConsistentRead" => false,
    'ProjectionExpression' => 'City,Category,Activity,Notes,VenueName',
    'KeyConditionExpression' =>  "CityAndCategory = :cityAndCategory",
    'ExpressionAttributeValues' => [
        ":cityAndCategory" => ["S" => "london|sports"],
    ],
];

$params_LSI = [
    'TableName' => 'Venues',
    'IndexName' => 'CityAndActivityPerCategory',
    "ConsistentRead" => false,
    'ProjectionExpression' => 'City,Category,Activity,Notes,VenueName',
    'KeyConditionExpression' =>  "CityAndActivity = :cityAndActivity",
    'ExpressionAttributeValues' => [
        ":cityAndActivity" => ["S" => "london|running"],
    ],
];

$response = $dynamodb->query($params_LSI);
print_r($response['Items']);
?>