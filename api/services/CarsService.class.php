<?php
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/CarsDao.class.php";

/**
 * Cars Service Class inheriting Base Service Class
 * 
 */
class CarsService extends BaseService {

    public function __construct() {
        $this->dao = new CarsDao();
    }

    /**
     * Get all car brand names
     * @return array Array of car names and their ID's
     */
    public function get_car_brands() {
        return $this->dao->get_car_brands();
    }

    /**
     * Get all car model names, by Brand ID
     * @param  int $brand ID of the brand
     * @return array Array of car models and their ID's
     */
    public function get_car_models($brand) {
        return $this->dao->get_car_models($brand);
    }

}
