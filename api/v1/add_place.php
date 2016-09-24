<?php

include "../Clients/DynamoDb.php";
require 'Response.php';


date_default_timezone_set('UTC');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::withError('Bad Request', 400);
}

$tableName = 'Venues';
$dynamodb = new CityActivity\Clients\DynamoDb();

$city = $_POST['city'] ?: null;
$name = $_POST['name'] ?: null;
$activity = $_POST['activity'] ?: null;
$category = $_POST['category'] ?: null;
$country = $_POST['country'] ?: null;
$address = $_POST['address'] ?: null;
$notes = $_POST['notes'] ?: null;
$picture = $_POST['picture'] ?: null;

$json = json_encode([
    'CityAndActivity' => buildHashKeyFromAttributes($city, $activity), //PK
    'CityAndCategory' => buildHashKeyFromAttributes($city, $category), //GSI
    'VenueName' => $name,
    'City' => $city,
    'Activity' => $activity,
    'Category' => $category,
    'Country' => $country,
    'Address' => $address,
    'Notes' => $notes,
    'Picture' => $picture
]);

$dynamodb->saveItem($tableName, $json);
$response = ['Created'];
Response::sendSuccess($response);


/**
 * @param $location
 * @param $type [activity/category]
 * @return string
 */
function buildHashKeyFromAttributes($location, $type)
{
    return strtolower(trim($location)) . '|' . strtolower(trim($type));
}

?>
