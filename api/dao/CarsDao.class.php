<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

/**
 * Cars Class inheriting BaseDao class, for car models and brands
 *
 */
class CarsDao extends BaseDao {

    public function __construct() {
        parent::__construct("cars");
    }

    /**
     * Get all car brands from DB
     * @return object Array of car brands
     */
    public function get_car_brands() {
        return $this->query("SELECT * FROM cars WHERE father_id = 0", []);
    }

    /**
     * Get car brand's models from DB
     * @param  int $brand ID of the brand
     * @return object        Array of car models
     */
    public function get_car_models($brand) {
        return $this->query("SELECT * FROM cars WHERE father_id = :brand",
                            ["brand" => $brand]);
    }

}
