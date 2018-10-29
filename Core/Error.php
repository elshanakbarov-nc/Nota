<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 12/31/2017
 * Time: 6:11 PM
 */

namespace Core;


class Error {

    /**
     * Error handler. Convert all errors to Exception by throwing an ErrorException.
     *
     * @param int $level Error level
     * @param string $message Error Message
     * @param string $file Filename the error was raised in
     * @param int $line line number in the file
     *
     * @return void
     */


    public static function errorHandler($level,$message,$file,$line){

          if(error_reporting() !== 0){
              throw new \ErrorException($message,0 , $level,$file , $line );
          }

    }

    public static function exceptionHandler($exception){

        // Code is 404 (Not Found) or 500 (general error)
        $code  = $exception->getCode();

        if ($code != 404){
            $code = 500;
        }

        http_response_code($code);

       if(\App\Config::SHOW_ERRORS){

           echo "<h1>Fatal Error</h1>";
           echo "<p>Uncaught exception: '".get_class($exception)."'</p>";
           echo "<p>Message: '".$exception->getMessage()."'</p>";
           echo "<p>Stack trace: <pre>". $exception->getTraceAsString() ."</pre></p>";
           echo "<p>Thrown in '".$exception->getFile() ."' on line ".$exception->getLine()."</p>";

       }else{

           $log = dirname(__DIR__) . '/logs/'.date('Y-m-d').'.txt';
           ini_set('error_log',$log);

           $message = "Uncaught exception: '".get_class($exception) ."'";
           $message .= "With message '".$exception->getMessage()."'";
           $message .= "\nStack Trace: ". $exception->getTraceAsString();
           $message .= "\nThrown in '".$exception->getFile()."' on line " . $exception->getLine();

           error_log($message);

            View::renderTemplate("$code.html");

       }



    }

}