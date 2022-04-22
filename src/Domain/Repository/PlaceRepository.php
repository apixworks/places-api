<?php

namespace App\Domain\Repository;

// Require Composer's autoloader.
require __DIR__ . '/../../../vendor/autoload.php';

use Psr\Container\ContainerInterface;

// Using Medoo namespace.
use Medoo\Medoo;

/**
 * Repository.
 */
class PlaceRepository
{
    /**
     * @var Medoo database connection
     */
    private $db;

    private static $instance = null;


    /**
     * Constructor.
     *
     * MySQL database connection
     */
    public function __construct()
    {
        $this->db = new Medoo([
            'type' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'places_db',
            'username' => 'root',
            'password' => ''
        ]);
    }


    public static function getInstance()
    {
        if(!self::$instance)
        {
        self::$instance = new PlaceRepository();
        }
    
        return self::$instance;
    }
    

    public function getConnection()
    {
        return $this->db;
    }


    /**
     * Insert a place into the database.
     *
     * @param array $place The place
     *
     * @return string status of the insert
     */
    public function insertPlace(array $place)
    {
        $instance = PlaceRepository::getInstance();
        $database = $instance->getConnection();
        $data = $database->insert("tbl_places", [
            "name" => $place['name'],
            "slug" => $place['slug'],
            "city" => $place['city'],
            "state" => $place['state'],
            "image" => $place['image'],
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ]);
        return $data->rowCount();
    }


    /**
     * Update a place in the database.
     *
     * @param array $place The place
     *
     * @return string status of the insert
     */
    public function updatePlace(array $place)
    {
        $instance = PlaceRepository::getInstance();
        $database = $instance->getConnection();
        $data = $database->update("tbl_places", [
            "id" => $place['id'],
            "name" => $place['name'],
            "slug" => $place['slug'],
            "city" => $place['city'],
            "state" => $place['state'],
            "image" => $place['image'],
            "updated_at" => date('Y-m-d H:i:s'),
        ],[
            "id" => $place['id']
        ]);
        return $data->rowCount();
    }


    /**
     * Get a specific place in the database.
     *
     * @param int $place The place
     *
     * @return object place details
     */
    public function getPlace(int $place_id)
    {
        $instance = PlaceRepository::getInstance();
        $database = $instance->getConnection();
        $data = $database->select("tbl_places", [
            "id",
            "name",
            "slug",
            "city",
            "state",
            "image",
        ],[
            "id" => $place_id
        ]);
        return $data->rowCount();
    }


    /**
     * Get all places in the database.
     *
     * @return array place details
     */
    public function getAllPlaces()
    {
        $instance = PlaceRepository::getInstance();
        $database = $instance->getConnection();
        $data = $database->select("tbl_places", [
            "id",
            "name",
            "slug",
            "city",
            "state",
            "image",
        ],[
            "ORDER" => "name"
        ]);
        return $data;
    }

}