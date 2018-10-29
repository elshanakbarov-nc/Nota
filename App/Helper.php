<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/3/2018
 * Time: 2:09 PM
 */

namespace App;

class Helper extends \Core\Model
{

    /**
     * Gets the route parameters
     * @return String
    */

    public static function getURL(){

        $url = $_SERVER['QUERY_STRING'];

        $urlString = explode("/" , $url);
        
        if (count($urlString) == 3 || count($urlString) == 4) {

            if (isset($_GET["lang"] , $_GET["tab"]) && !isset($_GET["section"])){

                $urlString = explode("=", $urlString[2]);
                return $urlString[2];

            }
            elseif (isset($_GET["lang"] ,$_GET["tab"] , $_GET["section"])) {

                $urlString = explode("=", $urlString[2]);
                return $urlString[3];

              }

            elseif (isset($_GET["tab"],$_GET["section"])) {
                
                $urlString = explode("=", $urlString[2]);
                return $urlString[2];

            }

            elseif (!isset($_GET["lang"]) && isset($_GET["tab"])){

                $urlString = explode("=", $urlString[2]);
                return $urlString[1];

            }

            if (isset($_GET["lang"])) {

                $urlString = explode("&", $urlString[2]);
                return $urlString[0];

            }

            return $urlString[2];
            
        }else{
            
            $urlString[2] = null;
            return $urlString[2];
            
       }

    }

    /**
     * Gets the lang parametrs from @array $_GET
     * @return String
     */

    public static function getLang(){

        if (isset($_GET['lang'])){

            return $_GET['lang'];

        }

    }

    /**
     * @param $str
     * @return string
     */

    public static function sefLink ($str)
    {
        // converts upper to lower
        $str = mb_strtolower($str,'UTF-8');

        // replace characters
        $str = str_replace(
            ['ı','ə','ğ','ö','ü','ç','ş'],
            ['i','e','g','o','u','c','s'] ,
            $str
        );

        // replace chars with '-' other than digits and strings
        $str = preg_replace('/[^a-z0-9]/','-',$str );

        // replace more '-' with single '-'
        $str = preg_replace('/-+/','-',$str);

        // trims '-' at the start and end of the string
        return trim($str,'-');

    }

    /**
     * Helper function for pre print_r
     * @param $data
     */
    public static function print($data)
    {

        print_r("<pre>");
        print_r($data);
        print_r("</pre>");

    }

    public static function escape ($string)
    {
        $db = self::getDB();
        return  mysqli_real_escape_string($db,$string);
    }

}