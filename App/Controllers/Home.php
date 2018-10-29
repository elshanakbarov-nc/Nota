<?php

namespace App\Controllers;

use App\Helper;
use \Core\View;
use \App\Auth;
use \App\Mail;

use App\Admin\Models\Partner as AdminPartner;
use App\Models\City as CityModel;
use App\Admin\Models\City as AdminCity;
use App\Admin\Models\Post as AdminPost;
use App\Admin\Models\News as AdminNews;
use App\Models\Home as ModelHome;
use App\Models\Feedback as FeedbackModel;
use App\Models\Navigation as NavigationModel;
use App\Models\Training as TrainingModel;
use App\Admin\Models\Setting as SettingModel;

class Home extends \Core\Controller {

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction() {
        $about = CityModel::getAboutInfo();
        View::renderTemplate('Home/index.html',[
            'about' => $about,
            "partners" => AdminPartner::findAll(),
            "announces"   => AdminPost::getAnnounces(),
            "events"       => AdminPost::findAll(),
            "news"       => AdminNews::findAll(),
            "feedbacks" =>  FeedbackModel::getFeedback(),
           "navigation" => NavigationModel::getCategory(),
            "sliders"   => SettingModel::allSlider(),
            "indicatorCount" => 0,
            "contact"      => SettingModel::getContact(),
            "links"        => SettingModel::getLinks(),
            "social"       => SettingModel::getSocials()

        ]);
    }

    /**
     * Show the about page
     *
     * @return void
     */
    public function aboutAction() {
        $city = CityModel::getCity();
         $about = CityModel::getAboutInfo();
        View::renderTemplate('Home/about.html', [
            'about' => $about,
            'cities' => $city,
            "navigation" => NavigationModel::getCategory(),
            "links"        => SettingModel::getLinks(),
            "social"       => SettingModel::getSocials(),
            "contact"      => SettingModel::getContact(),

        ]);
    }

    public function showAction() {

        $city = CityModel::getCity();
        $adminCity = new AdminCity();
        View::renderTemplate('Home/about.html', [

            'cities' => $city,
            "route_name" => $this->route_params["name"],
            "photos"  =>$adminCity->photoById($this->route_params["id"]),
            'city_info' => CityModel::getCityInfo($this->route_params["name"]),
            "navigation" => NavigationModel::getCategory(),
            "links"        => SettingModel::getLinks(),
            "social"       => SettingModel::getSocials(),
            "contact"      => SettingModel::getContact(),

        ]);
    }

    public function contactAction ()
    {

        View::renderTemplate("Home/contact.html",[
            "contact"      => SettingModel::getContact(),
            "links"        => SettingModel::getLinks(),
            "social"       => SettingModel::getSocials()
        ]);

    }

    public function search ()
    {

        if (isset($_POST["search"])){

            if (count(ModelHome::search($_POST["search"])) >= 1) {

                echo "Found";

            }else{

                echo "Not Found";
            }

        }

    }

}

?>
