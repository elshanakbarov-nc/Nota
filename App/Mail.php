<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/5/2018
 * Time: 4:53 PM
 */

namespace App;
use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{

    /**
     * Send a message
     *
     * @param string $to Receipt
     * @param string $subject Subject
     * @param string $text Text-only content of the message
     * @param string $html HTML content of message
    */

    public static function send($to,$subject,$text,$html = null){

            $mail = new PHPMailer();

       try{

           $mail->isSMTP();
           $mail->CharSet = "text/html; charset=UTF-8;";
           $mail->Host = 'ssl://smtp.gmail.com';
           $mail->Port = '465';
           $mail->SMTPAuth = true;
           $mail->Username = '';
           $mail->Password = '';
           $mail->SMTPSecure = 'ssl';
           $mail->From = '';
           $mail->FromName = '';
           $mail->addAddress($to);
           $mail->WordWrap = 50;
           $mail->isHTML(true);
           $mail->Subject = $subject;
           $mail->Body = $text;
           $mail->send();
           echo "Mail has been sent";

       }catch (Exception $e){
           throw new \Exception("Message could not be sent. Mailer Error: ", $mail->ErrorInfo);
       }

    }

}
