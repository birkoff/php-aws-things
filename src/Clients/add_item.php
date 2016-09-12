<?php

namespace leisureManager;

include "DynamoDb.php";

date_default_timezone_set('UTC');

use leisureManager\Clients\DynamoDb;

$tableName = 'Venues';
$venues = json_decode(file_get_contents('venuedata.json'), true);

$dynamodb = new DynamoDb();

foreach ($venues as $venue) {
    $city = $venue['city'];
    $name = $venue['name'];
    $activity = $venue['activity'];
    $country = $venue['country'];
    $address = $venue['address'];
    $notes = $venue['notes'];
    $picture = $venue['picture'];

    $activityCity = $activity . ', ' . $city;

    $json = json_encode([
        'activity_city' => $activityCity,
        'city' => $city,
        'name' => $name,
        'activity' => $activity,
        'country' => $country,
        'address' => $address,
        'notes' => $notes,
        'picture' => $picture
    ]);

    $dynamodb->saveItem($tableName, $json);
}

?>