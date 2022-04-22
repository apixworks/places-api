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

}