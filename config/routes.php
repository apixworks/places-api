<?php

use Slim\App;

return function (App $app) {
    $app->post('/create', \App\Action\PlaceCreateAction::class);
};