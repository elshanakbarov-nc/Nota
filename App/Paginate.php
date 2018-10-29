<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 3/26/2018
 * Time: 4:20 PM
 */

namespace App;

class Paginate {

    /**
     * @var Paginate $current_page page which loaded
     */
    public $current_page;

    /**
     * @var Paginate $total_data total count of pages
     */
    public $total_data;

    /**
     * @var Paginate $data_per_page data amount for each page
     */
    public $data_per_page;

    /**
     * Paginate constructor.
     * @param int $page
     * @param int $data_per_page
     * @param $class Class name which paginated
     */
    public function __construct($page = 1, $data_per_page, $class) {
        $this->current_page = (int) $page;
        $this->data_per_page = (int) $data_per_page;
        $this->total_data = (int) $this->totalPage($class);
    }

    /**
     * @return Paginate|int
     */
    public function nextPage() {
        return $this->current_page + 1;
    }

    /**
     * @return Paginate|int
     */
    public function previousPage() {
        return $this->current_page - 1;
    }

    /**
     * @param $class
     * @return float
     */
    public function totalPage($class) {
        return ceil(count($class::findAll()) / $this->data_per_page);
    }



    /**
     * @return bool
     */
    public function hasPrevious() {
        return $this->previousPage() >= 1 ? true : false;
    }

    /**
     * @return bool
     */
    public function hasNext() {
        return $this->nextPage() <= $this->totalPage($this->class) ? true : false;
    }

    /**
     * @return Paginate|int
     */
    public function offset() {
        return ($this->current_page - 1 ) * $this->data_per_page;
    }

}
