<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CarsDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("cars");
    }

    public function get_car_brands()
    {
        return $this->query("SELECT * FROM cars WHERE father_id = 0", []);
    }

    public function get_car_models($brand)
    {
        return $this->query("SELECT * FROM cars WHERE father_id = :brand",
                            ["brand" => $brand]);
    }
}
