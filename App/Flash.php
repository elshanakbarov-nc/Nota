<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/2/2018
 * Time: 5:12 PM
 */

namespace App;


class Flash
{

    /**
     * Success message type
     * @var string
    */

    const SUCCESS = 'success';

    /**
     * Information message type
     * @var string
    */

    const INFO = 'info';

    /**
     * Warning message type
     * @var string
    */

    const WARNING = 'warning';

    /**
     * Add a message
     * @param string $msg
     * @return void
     * @internal param string $message The message content
     */

    public static function addMessage($msg,$type = 'success'){

        // Create array in the session if it doesn't already exists
        if(!isset($_SESSION['flash_notification'])){
                 $_SESSION['flash_notification'] = [];
        }

        // Append the message to the array
        $_SESSION['flash_notification'][] = [
            'body' => $msg,
            'type' => $type
        ];

    }


    /**
     *  Get all the messages
     * @return mixed an Array with all the messages or null if none set
    */
    public static function getMessage(){

        if (isset($_SESSION['flash_notification'])){
            $message = $_SESSION['flash_notification'];
            unset($_SESSION['flash_notification']);
            return $message;
        }

    }

}