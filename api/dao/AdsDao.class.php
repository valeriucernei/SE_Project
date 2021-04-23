<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AdsDao extends BaseDao{
    public function __construct(){
      parent::__construct("ads");

    }

    public function get_all_ads($offset, $limit, $order, $user_id, $car_body, $fabricated_min,
                            $fabricated_max, $km_min, $km_max, $price_min, $price_max,
                            $gearbox, $fuel_type, $motor_size_min, $motor_size_max){

        list($order_column, $order_direction) = self::parse_order($order);

        $query = "SELECT * FROM ads_list WHERE 1 = 1";

        if($user_id > 0) $query .= " AND user_id = ${user_id}";
        if($car_body > 0) $query .= " AND car_body = ${car_body}";
        $query .= " AND fabricated >= :fabricated_min";
        $query .= " AND fabricated <= :fabricated_max";
        $query .= " AND km >= :km_min";
        $query .= " AND km <= :km_max";
        $query .= " AND price >= :price_min";
        $query .= " AND price <= :price_max";
        if($gearbox > 0) $query .= " AND gearbox = ${gearbox}";
        if($fuel_type > 0) $query .= " AND fuel_type = ${fuel_type}";
        $query .= " AND motor_size >= :motor_size_min";
        $query .= " AND motor_size <= :motor_size_max";

        $query .= " ORDER BY ${order_column} ${order_direction}
                    LIMIT ${limit} OFFSET ${offset}";

        return $this->query($query, [
                            "fabricated_min" => $fabricated_min,
                            "fabricated_max" => $fabricated_max,
                            "km_min" => $km_min,
                            "km_max" => $km_max,
                            "price_min" => $price_min,
                            "price_max" => $price_max,
                            "motor_size_min" => $motor_size_min,
                            "motor_size_max" => $motor_size_max
        ]);
    }

    public function get_ad_by_id($id){
        return $this->query_unique("SELECT * FROM ads_list
                                    WHERE id = :id", ["id" => $id]);
    }

    public function get_ads($search, $offset, $limit, $order, $user_id, $car_body,
                            $fabricated_min, $fabricated_max, $km_min, $km_max,
                            $price_min, $price_max, $gearbox, $fuel_type ,
                            $motor_size_min, $motor_size_max){

        list($order_column, $order_direction) = parent::parse_order($order);

        $query = "SELECT * FROM ads_list
                  WHERE LOWER(title) LIKE CONCAT('%', :title, '%')";
        if($user_id > 0) $query .= " AND user_id = ${user_id}";
        if($car_body > 0) $query .= " AND car_body = ${car_body}";
        $query .= " AND fabricated >= :fabricated_min";
        $query .= " AND fabricated <= :fabricated_max";
        $query .= " AND km >= :km_min";
        $query .= " AND km <= :km_max";
        $query .= " AND price >= :price_min";
        $query .= " AND price <= :price_max";
        $query .= " AND motor_size >= :motor_size_min";
        $query .= " AND motor_size <= :motor_size_max";
        if($gearbox > 0) $query .= " AND gearbox = ${gearbox}";
        if($fuel_type > 0) $query .= " AND fuel_type = ${fuel_type}";

        $query .= " ORDER BY ${order_column} ${order_direction}
                    LIMIT ${limit} OFFSET ${offset}";

        return $this->query($query, [
                            "title" => strtolower($search),
                            "fabricated_min" => $fabricated_min,
                            "fabricated_max" => $fabricated_max,
                            "km_min" => $km_min,
                            "km_max" => $km_max,
                            "price_min" => $price_min,
                            "price_max" => $price_max,
                            "motor_size_min" => $motor_size_min,
                            "motor_size_max" => $motor_size_max
        ]);
    }

}
