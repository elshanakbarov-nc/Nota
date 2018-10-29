<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/21/2018
 * Time: 2:41 PM
 */

namespace App\Admin\Controllers;

use \Core\View;

class Home extends \App\Controllers\Authenticated
{
    /**
     *Show the index page
     *
     * @return void
     */
    public function showAction()
    {

        View::renderTemplate("Home/index.html");

    }


}