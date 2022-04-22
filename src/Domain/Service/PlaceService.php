<?php

namespace App\Domain\Service;

use App\Domain\Repository\PlaceRepository;

/**
 * Service.
 */
final class PlaceService
{
    /**
     * @var PlaceRepository
     */
    private $repository;


    /**
     * The constructor.
     *
     * @param PlaceRepository $repository The repository
     */
    public function __construct(PlaceRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Add a new place.
     *
     * @param array $data The form data
     *
     * @return int The new place status after creation
     */
    public function createPlace(array $data): int
    {
        // Call Insert place function in PlaceRepository
        $result = $this->repository->insertPlace($data);

        return $result;
    }


    /**
     * Edit a new place.
     *
     * @param array $data The form data
     *
     * @return int The updated place status after editing
     */
    public function editPlace(array $data): int
    {
        // Call Edit place function in PlaceRepository
        $result = $this->repository->updatePlace($data);

        return $result;
    }


    /**
     * Get all places.
     *
     * @return array All places filtered by names
     */
    public function viewAllPlaces(): array
    {
        // Call get all places function in PlaceRepository
        $result = $this->repository->getAllPlaces();

        return $result;
    }

}