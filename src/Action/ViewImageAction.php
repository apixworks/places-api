<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ViewImageAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $directory = __DIR__ . '/../../public/images';
        $image_name = $request->getAttribute('name');
        $images = glob($directory . "/*.*");
        foreach($images as $image){
            $image_info = pathinfo($image);
            if($image_info['filename'] == $image_name){
                $image_path = $image;
            }
        }
        $file = $image_path;
        if (!file_exists($file)) {
            die("file:$file");
            // Transform the result into the JSON representation
            $result = [
                'error' => 'Image not found'
            ];

            // Build the HTTP response
            $response->getBody()->write((string)json_encode($result));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
        $image = file_get_contents($file);
        if ($image === false) {
            die("error getting image");
            // Transform the result into the JSON representation
            $result = [
                'error' => 'Error getting image'
            ];

            // Build the HTTP response
            $response->getBody()->write((string)json_encode($result));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
        $response->getBody()->write($image);
        return $response->withHeader('Content-Type', 'image/'.explode($image_name.'.',$file)[1]);
    }
}