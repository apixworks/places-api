<?php

use Slim\App;

return function (App $app) {

    // Create place endpoint
    $app->post('/places-api/create', \App\Action\PlaceCreateAction::class);

    // Edit place endpoint
    $app->post('/places-api/edit', \App\Action\PlaceEditAction::class);

    // Get all places endpoint
    $app->get('/places-api/places', \App\Action\PlacesGetAction::class);

    // Get place endpoint
    $app->get('/places-api/places/{id}', \App\Action\PlaceGetAction::class);

    // Upload image endpoint
    $app->post('/places-api/upload_image', \App\Action\PlaceImageUploadAction::class);
};