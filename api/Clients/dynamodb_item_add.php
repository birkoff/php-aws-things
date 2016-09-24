<?php

namespace CityActivity\Clients;

include "DynamoDb.php";

date_default_timezone_set('UTC');

use CityActivity\Clients\DynamoDb;

$tableName = 'Venues';
$venues = json_decode(file_get_contents('venuedata.json'), true);

$dynamodb = new DynamoDb();

foreach ($venues as $venue) {
    $city = $venue['city'];
    $name = $venue['name'];
    $activity = $venue['activity'];
    $category = $venue['category'];
    $country = $venue['country'];
    $address = $venue['address'];
    $notes = $venue['notes'];
    $picture = $venue['picture'];

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
}
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