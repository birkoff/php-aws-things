<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->post('/venue', 'CityActivity\Controllers\\VenueController::create');

$app->after(function (Response $response) {
    $response->headers->set('Content-Type', 'application/json');
});

$app->run();