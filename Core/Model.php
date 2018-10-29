<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 12/29/2017
 * Time: 10:22 PM
 */


namespace Core;

use PDO;

use App\Config;
use App\Paginate;

class Model{


    /**
     * Error messages
     *
     * @var array
     */

    public $errors = [];

    /**
     * Get the PDO database connection
     *
     * @return void
     */



    /**
     * Error messages for photo upload process
     *
     * @var array
     */


    public $upload_errors_array = [

        UPLOAD_ERR_OK         => "There is no error",
        UPLOAD_ERR_INI_SIZE   => "The upload file exceeds the upload_max_size directive",
        UPLOAD_ERR_FORM_SIZE  => "The uploaded file exceeds the max_file_size directive",
        UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded",
        UPLOAD_ERR_NO_FILE    => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporery folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION  => "A PHP extension stopped to file upload"
    ];

    protected static function getDB(){

        static $db = null;

        if ($db === null){

                $dsn = 'mysql:host='.Config::DB_HOST. ';dbname='.Config::DB_NAME. ';charset=utf8';
                $db = new \PDO($dsn ,Config::DB_USER,Config::DB_PASS);

                // Throw an Exception when an error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }

    public function getErrors(){
        return $this->errors;
    }


}