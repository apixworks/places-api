<?php

namespace App\Action;

use App\Domain\Service\PlaceService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PlaceImageUploadAction
{
    // Reference image saving path
    private $directory = __DIR__ . '/../../public/images';

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
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Get uploaded image
        $uploadedFiles = $request->getUploadedFiles();

        // Get uploaded image
        $newfile = $uploadedFiles['image'];
        if ($newfile){
            $data['image'] = '';
        }

        //Ensuring all required fields are filled
        $result = array_diff(['id','image'], array_keys($data));
        if (count($result) > 0) {
            // Build the HTTP response
            $response->getBody()->write((string)json_encode(['error' => 'Missing required fields', 'Missing fields' => array_values($result)]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }else{

            // Rename and store uploaded image
            if ($newfile->getError() === UPLOAD_ERR_OK) {
                $uploadFileName = $newfile->getClientFilename();
                $img_name = strval(time()).".".explode(".",$uploadFileName)[1];
                // $newfile->moveTo($directory . DIRECTORY_SEPARATOR . $img_name);
                $data['image'] = $img_name;
            }

            // Invoke the Domain with inputs and retain the result
            $status = $this->placeService->uploadImage($data);

            // Transform the result into the JSON representation
            if($status == 1){
                $result = [
                    'result' => 'Image has successful been uploaded'
                ];
            }else{
                $result = [
                    'result' => 'Failed'
                ];
            }

            // Build the HTTP response
            $response->getBody()->write((string)json_encode($result));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }
}