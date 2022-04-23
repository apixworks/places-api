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
        $places = $this->placeService->viewAllPlaces();

        foreach($places as &$place){
            $image_name = explode('.',$place['image'])[0];
            $place['image'] = 'https://asyx-places-api.herokuapp.com/places-api/view/image/'.$image_name;
        }

        // Transform the result into the JSON representation
        $places = [
            'places' => $places
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($places));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}