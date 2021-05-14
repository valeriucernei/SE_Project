<?php
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/CarsDao.class.php";

class CarsService extends BaseService
{
    public function __construct()
    {
        $this->dao = new CarsDao();
    }

    public function get_car_brands()
    {
        return $this->dao->get_car_brands();
    }

    public function get_car_models($brand)
    {
        return $this->dao->get_car_models($brand);
    }
}
