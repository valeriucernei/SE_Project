<?php
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/AdsDao.class.php";
require_once dirname(__FILE__)."/../dao/AtributesDao.class.php";
require_once dirname(__FILE__)."/../dao/PhotosDao.class.php";
require_once dirname(__FILE__)."/../clients/CDNClient.class.php";

/**
 * Listings Service Class extending BaseService Class
 * 
 */
class AdsService extends BaseService {

    private $atributesDao;
    private $photosDao;
    private $CDNClient;

    public function __construct() {
        $this->dao = new AdsDao();
        $this->atributesDao = new AtributesDao();
        $this->photosDao = new PhotosDao();
        $this->CDNClient = new CDNClient();
    }

    /**
     * Get all ads by specific search
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
     * @return array                 Array of listings
     */
    public function get_ads($search, $offset, $limit, $order, $user_id, $brand,
                            $model, $car_body, $fabricated_min, $fabricated_max,
                            $km_min, $km_max, $price_min, $price_max, $gearbox,
                            $fuel_type, $motor_size_min, $motor_size_max) {

        if($search)
            return $this->dao->get_ads($search, $offset, $limit, $order, $user_id,
                                      $brand, $model, $car_body, $fabricated_min,
                                      $fabricated_max, $km_min, $km_max, $price_min,
                                      $price_max, $gearbox, $fuel_type,
                                      $motor_size_min, $motor_size_max);
         else
            return $this->dao->get_all_ads($offset, $limit, $order, $user_id,
                                          $brand, $model, $car_body, $fabricated_min,
                                          $fabricated_max, $km_min, $km_max,
                                          $price_min, $price_max, $gearbox, $fuel_type,
                                          $motor_size_min, $motor_size_max);
    }

    /**
     * Get Listing by it's ID
     * @param  int $id ID of the listing
     * @return object     Object of listings data
     */
    public function get_ad_by_id($id) {
        $result = $this->dao->get_ad_by_id($id);

        if(!$result) throw new Exception("This ad doesn't exist.", 404);
        else return $this->dao->get_ad_by_id($id);
    }

    /**
     * Publish new Listing in Data Base
     * @param object $user Object of user's data
     * @param object $data Object of Listing's data
     * @return object     Object of new Listing with ID
     */
    public function add_ad($user, $data) {
        $data = $this->check_ad_data($data);

        try {
            $this->dao->beginTransaction();

            $ad = $this->dao->add([
                "user_id" => $user['id'],
                "title" => $data['title'],
                "description" => $data['description'],
                "model" => $data['model']]);

            $atributes = $this->atributesDao->add([
                "car_body" => $data['car_body'],
                "fabricated" => $data['fabricated'],
                "km" => $data['km'],
                "price" => $data['price'],
                "gearbox" => $data['gearbox'],
                "fuel_type" => $data['fuel_type'],
                "motor_size" => $data['motor_size'],
                "ad_id" => 1]);

            $this->dao->commit();
        } catch (\Exception $e) {
            $this->dao->rollBack();
            throw new Exception("Something went wrong! Ad has not been added.
                                Please, try again.", 400, $e);
        }
        $this->atributesDao->update($atributes['id'], ["ad_id" => $ad['id']]);

        return $this->dao->get_ad_by_id($ad['id']);
    }

    /**
     * Check and validate listings required data
     * @param  object $data Listing's data
     * @return object       Validated listings object
     */
    public function check_ad_data($data) {
        if(!isset($data['title']))
            throw new Exception("Title field is required.");
        if(!isset($data['car_body']))
            throw new Exception("Car Body field is required.");
        if(!isset($data['fabricated']))
            throw new Exception("Year field is required.");
        if(!isset($data['model']))
            throw new Exception("Model field is required.");

        if(!isset($data['description']) || strlen($data['description']) < 1)
            $data['description'] = null;
        if(!isset($data['km']) || strlen($data['km'])<1)
            $data['km'] = "0";
        if(!isset($data['motor_size']) || strlen($data['motor_size']) < 1)
            $data['motor_size'] = "0";
        if(!isset($data['gearbox']) || strlen($data['gearbox']) < 1)
            $data['gearbox'] = "0";
        if(!isset($data['fuel_type']) || strlen($data['fuel_type']) < 1)
            $data['fuel_type'] = "0";
        if(!isset($data['price']) || strlen($data['price']) < 1)
            $data['price'] = "0";

        return $data;
    }

    /**
     * Verify is user own's the listing
     * @param  int $id ID of user
     * @param  object $ad Object of Listing
     * @return bool     True if user own the Listing
     */
    public function verify_ad_user($id, $ad) {
        $ad = $this->dao->get_ad_by_id($ad);

        if($id == $ad['user_id']) {
            return true;
        } else {
            throw new Exception("You don't have access to this ad.", 400);
        }
    }

    /**
     * Update user's Listing
     * @param int $user_id ID of the user
     * @param int $ad_id   ID of the Listing
     * @param object $data    Data for the new Listing
     * @return object          Updated listing object
     */
    public function update_user_ad($user_id, $ad_id, $data) {
        if($this->verify_ad_user($user_id, $ad_id))
            return $this->update_ad($ad_id, $data);
    }

    /**
     * Update ad after checking ownership
     * @param  int $id   ID of the ad
     * @param  object $data Object of listing's data
     * @return object       [description]
     */
    public function update_ad($id, $data) {
        $data = $this->check_ad_data($data);

        try {
            $this->dao->beginTransaction();

            $ad = $this->dao->update($id, [
                "title" => $data['title'],
                "description" => $data['description'],
                "model" => $data['model'],
                "updated" => date(Config::DATA_FORMAT)]);

            $atr_id = $this->atributesDao->get_atributes_id($id);

            $atributes = $this->atributesDao->update($atr_id['id'], [
                "car_body" => $data['car_body'],
                "fabricated" => $data['fabricated'],
                "km" => $data['km'],
                "price" => $data['price'],
                "gearbox" => $data['gearbox'],
                "fuel_type" => $data['fuel_type'],
                "motor_size" => $data['motor_size']]);

            $this->dao->commit();
        } catch (\Exception $e) {
            $this->dao->rollBack();
            throw new Exception("Something went wrong! Ad has not been updated.
                                Please, try again.", 400, $e);
        }
        return $this->dao->get_ad_by_id($id);
    }

    /**
     * Delete Listing from database and all it's photos from CDN
     * @param  int $user_id ID of the user
     * @param  int $ad_id   ID of the Listing
     * @return object          Object containing succes or failure message
     */
    public function delete_ad($user_id, $ad_id) {
        if($this->verify_ad_user($user_id, $ad_id)) {
            try {
                $photos = $this->photosDao->get_ads_photos($ad_id);

                foreach ($photos as $photo) {
                    $this->CDNClient->delete($photo['name']);
                }

                $this->atributesDao->delete_atributes($ad_id);
                $this->photosDao->delete_photos($ad_id);
                $this->dao->delete_ad($ad_id);

            } catch (\Exception $e) {
                throw new Exception("Something went wrong!", 500, $e);
            }
            return ['message' => 'Success!'];
        }
    }

}
