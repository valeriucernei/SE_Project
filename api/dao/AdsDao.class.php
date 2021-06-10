<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

/**
 * Listings class inheriting BaseDao Class
 *
 */
class AdsDao extends BaseDao {

    public function __construct() {
        parent::__construct("ads");

    }

    /**
     * Method to request all listings from DB with specific requirements
     * @param  int $offset         Offset for listings
     * @param  int $limit          Limit of listings from Query
     * @param  string $order       Order for sorting listings, + desc, - asc.
     * @param  int $user_id        ID of the ad owner
     * @param  int $brand          ID of car brand
     * @param  int $model          ID of car model
     * @param  int $car_body       ID of car body
     * @param  int $fabricated_min Minimum fabrication year
     * @param  int $fabricated_max Maximal fabrication year
     * @param  int $km_min         Minimal car mileage
     * @param  int $km_max         Maximal car mileage
     * @param  int $price_min      Minimal car price
     * @param  int $price_max      Maximal car price
     * @param  int $gearbox        ID of gearbox
     * @param  int $fuel_type      ID of fuel type
     * @param  int $motor_size_min Minimal motor size
     * @param  int $motor_size_max Maximal motor size
     * @return object                 Object container all listings
     */
    public function get_all_ads($offset, $limit, $order, $user_id, $brand, $model,
                            $car_body, $fabricated_min, $fabricated_max, $km_min,
                            $km_max, $price_min, $price_max, $gearbox, $fuel_type,
                            $motor_size_min, $motor_size_max) {

        list($order_column, $order_direction) = self::parse_order($order);

        $query = "SELECT * FROM ads_list WHERE 1 = 1";

        if($user_id > 0) $query .= " AND user_id = ${user_id}";
        if($brand > 0) $query .= " AND brand = ${brand}";
        if($model > 0) $query .= " AND model = ${model}";
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

    /**
     * Method for returning one AD by ID
     * @param  int $id Id of the user
     * @return object     Object of user's data
     */
    public function get_ad_by_id($id) {
        return $this->query_unique("SELECT * FROM ads_list
                                    WHERE id = :id", ["id" => $id]);
    }

    /**
     * Method of returning number of all ADs
     * @return object Object containing number of ads
     */
    public function get_ads_count() {
        return $this->query("SELECT COUNT(id) as count FROM ads_list", NULL);
    }

    /**
     * Get all listings, searching by a specific title
     * @param  string $search      String containing search words for title
     * @param  int $offset         Offset for listings
     * @param  int $limit          Limit of listings from Query
     * @param  string $order       Order for sorting listings, + desc, - asc.
     * @param  int $user_id        ID of the ad owner
     * @param  int $brand          ID of car brand
     * @param  int $model          ID of car model
     * @param  int $car_body       ID of car body
     * @param  int $fabricated_min Minimum fabrication year
     * @param  int $fabricated_max Maximal fabrication year
     * @param  int $km_min         Minimal car mileage
     * @param  int $km_max         Maximal car mileage
     * @param  int $price_min      Minimal car price
     * @param  int $price_max      Maximal car price
     * @param  int $gearbox        ID of gearbox
     * @param  int $fuel_type      ID of fuel type
     * @param  int $motor_size_min Minimal motor size
     * @param  int $motor_size_max Maximal motor size
     * @return object                 Object containing listings
     */
    public function get_ads($search, $offset, $limit, $order, $user_id, $brand,
                            $model, $car_body, $fabricated_min, $fabricated_max,
                            $km_min, $km_max, $price_min, $price_max, $gearbox,
                            $fuel_type, $motor_size_min, $motor_size_max) {

        list($order_column, $order_direction) = parent::parse_order($order);

        $query = "SELECT * FROM ads_list
                  WHERE LOWER(title) LIKE CONCAT('%', :title, '%')";

        if($user_id > 0) $query .= " AND user_id = ${user_id}";
        if($brand > 0) $query .= " AND model = ${brand}";
        if($model > 0) $query .= " AND model = ${model}";
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

    /**
     * Method to delete a listing from database
     * @param  int $ad_id ID of the ad to delete
     */
    public function delete_ad($ad_id) {
        return $this->query_unique("DELETE FROM `carmarket`.`ads`
                                    WHERE (`id` = :ad_id);",
                                    ["ad_id" => $ad_id]);
    }

}
