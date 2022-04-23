<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Tuupola\Middleware\HttpBasicAuthentication;

return function (App $app) {

    // Password protected area
    $app->group(
        '/places-api',
        function (RouteCollectorProxy $app) {
            // Create place endpoint
            $app->post('/create', \App\Action\PlaceCreateAction::class);

            // Edit place endpoint
            $app->post('/edit', \App\Action\PlaceEditAction::class);

            // Get all places endpoint
            $app->get('/places', \App\Action\PlacesGetAction::class);

            // Get place endpoint
            $app->get('/places/{id}', \App\Action\PlaceGetAction::class);

            // Upload image endpoint
            $app->post('/upload_image', \App\Action\PlaceImageUploadAction::class);
        }
    )->add(HttpBasicAuthentication::class);

    // Welcome endpoint
    $app->get('/', \App\Action\WelcomeAction::class);

    // Swagger API documentation
    $app->get('/places-api/docs/v1', \App\Action\Docs\SwaggerUiAction::class);

    // View place image
    $app->get('/places-api/view/image/{name}', \App\Action\ViewImageAction::class);
};