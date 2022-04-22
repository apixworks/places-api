<?php

namespace App\Action;

use App\Domain\Service\PlaceService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PlacesGetAction
{

    private $placeService;


    /**
     * The constructor.
     *
     * @param PlaceService $placeService The Service
     */
    public function __construct(PlaceService $placeService)
    {
        $this->placeService = $placeService;
    }


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {

        // Invoke the Domain to get the result
        $result = $this->placeService->viewAllPlaces();

        // Transform the result into the JSON representation
        $result = [
            'places' => $result
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}