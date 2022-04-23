<?php

namespace App\Action;

use App\Domain\Service\PlaceService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class PlaceGetAction
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

        // Get place id argument from the route
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $placeId = $route->getArgument('id');

        // Invoke the Domain to get the result
        $place = $this->placeService->viewPlace($placeId);

        $place['image'] = 'https://asyx-places-api.herokuapp.com/places-api/view/image/'.$place['image'];

        // Transform the result into the JSON representation
        $place = [
            'place' => $result
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($place));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}