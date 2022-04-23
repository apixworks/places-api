<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class WelcomeAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {

        // Transform the result into the JSON representation
        $result = [
            'message' => 'Welcome to Places-API'
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}