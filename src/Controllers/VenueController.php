<?php


namespace leisureManager\controllers;

use leisureManager\Clients\DynamoDb;
use leisureManager\Entity\Leisure;
use leisureManager\Entity\Venue;
use leisureManager\Models\LeisureModel;
use leisureManager\Models\VenueModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorController
{
    public function create(Request $request, Application $app)
    {
        $name = $request->get('name');
        $city = $request->get('city');
        $notes = $request->get('notes');
        $country = $request->get('country');
        $address = $request->get('address');
        $picture = $request->get('picture');
        $activity = $request->get('activity');

        $activityCity = $name .', ' . $city;

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

        $tableName = 'Venues';
        $dynamodb = new DynamoDb();
        $dynamodb->saveItem($tableName, $json);

        $response = json_encode(['created']);
        return new Response($response, 200);
    }
}

//        $venue = new Venue();
//
//        $venue->setActivityCity($activityCity)
//                ->setName($name)
//                ->setNotes($request->get('notes'))
//                ->setCountry($request->get('country'))
//                ->setCity($city)
//                ->setAddress($request->get('address'))
//                ->setPicture($request->get('picture'));

