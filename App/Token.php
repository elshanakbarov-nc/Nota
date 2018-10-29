<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/3/2018
 * Time: 4:16 PM
 */

namespace App;

/**
 *  Unique random tokens
*/

class Token
{
    /**
     * The token value
     * @var array
    */

    protected $token;

    /**
     *  Class constructor. Create a new random token
     * @return void
    */

    public function __construct($token_value = null)
    {
        $token_value ? $this->token = $token_value :
            $this->token = bin2hex(random_bytes(16));// 16 bytes = 128 bits = 32 hex chars

    }

    /**
     *  Get the token value
     * @return string the value
    */

    public function getValue(){
        return $this->token;
    }

    /**
     *  Get the hashed token value
     * @return string the hashed value
    */

    public function getHash(){
        return hash_hmac('sha256',$this->token,\App\Config::SECRET_KEY);
    }

}