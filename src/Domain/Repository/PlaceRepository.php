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
            'host' => getenv("REMOTEMYSQL_DATABASE"),
            'database' => getenv("REMOTEMYSQL_HOST"),
            'username' => getenv("REMOTEMYSQL_PASSWORD"),
            'password' => getenv("REMOTEMYSQL_USERNAME")
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
     * @return int status of the insert
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
        $data = $database->get("tbl_places", [
            "id",
            "name",
            "slug",
            "city",
            "state",
            "image",
            "created_at",
            "updated_at"
        ],[
            "id" => $place_id
        ]);
        return $data;
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
            "created_at",
            "updated_at"
        ],[
            "ORDER" => "name"
        ]);
        return $data;
    }


    /**
     * Update image of place in the database.
     *
     * @param array $data The place
     *
     * @return int status of the updation
     */
    public function updateImage(array $data)
    {
        $instance = PlaceRepository::getInstance();
        $database = $instance->getConnection();
        $result = $database->update("tbl_places", [
            "id" => $data['id'],
            "image" => $data['image'],
            "updated_at" => date('Y-m-d H:i:s'),
        ],[
            "id" => $data['id']
        ]);
        return $result->rowCount();
    }

}