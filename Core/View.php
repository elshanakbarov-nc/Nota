<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 12/19/2017
 * Time: 6:59 PM
 */

namespace Core;

use  Twig\Extensions;


class View
{


    /**
     * Render a view file
     *
     * @param string $view The view file
     *
     * @return void
     */

    public static function render($view, $args = [])
    {

        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view"; // Views files are stored at App/Views

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }

    }

    public static function renderTemplate($template, $args = [])
    {
        echo static::getTemplate($template, $args);
    }


    public static function getTemplate($template, $args = [])
    {

        static $twig = null;

        if ($twig === null) {

            $viewAddress = self::getViewAddress();

            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . $viewAddress);
            $twig = new \Twig_Environment($loader);
            //$twig->addGlobal('session',$_SESSION);
            // $twig->addGlobal('is_logged_in',\App\Auth::isLoggedIn());
            $twig->addGlobal('current_user', \App\Auth::getUser());
            $twig->addGlobal('flash_messages', \App\Flash::getMessage());
            $twig->addGlobal('source' , \App\Helper::getURL());
            $twig->addGlobal('lang' , \App\Helper::getLang());


        }

        return $twig->render($template, $args);
    }


    public static function getViewAddress(){

        if(preg_match("/^(?<folder>[a-z]+\/*)[a-z]*\/*[a-z]*/i" , $_SERVER['QUERY_STRING'] , $output_array)){

            $params = [];

            foreach ($output_array as $key => $value){

                if(is_string($key)){

                    $params[$key] = $value;

                    if (preg_match('/^admin/i' , $params["folder"])){

                        $view = "/App/Admin/Views";
                        return $view;


                    }

                }

            }
        }

        $view = "/App/Views";
        return $view;

    }


}