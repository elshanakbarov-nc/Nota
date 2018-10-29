<?php

namespace App\Controllers;

use App\Helper;
use \Core\View;
use \App\Auth;
use \App\Mail;

use App\Models\Home as ModelHome;


class Home extends \Core\Controller {

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction() {
        $about = CityModel::getAboutInfo();
        View::renderTemplate('Home/index.html',[]);
    }


}

?>
