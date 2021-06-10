<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

/**
 * Photos Class inheriting BaseDao, for controlling photos
 * 
 */
class PhotosDao extends BaseDao {

    public function __construct() {
        parent::__construct("photos");
    }

    /**
     * Method to get all Listing's photos
     * @param  int $id ID of the Listing
     * @return object     Array with images
     */
    public function get_ads_photos($id) {
        return $this->query("SELECT * FROM photos WHERE ad_id = :id",
                            ["id" => $id]);
    }

    /**
     * Delelete a specific photo from DataBase
     * @param  string $filename Name of the file
     * @return object           Message of success
     */
    public function remove($filename) {
        return parent::remove($filename);
    }

    /**
     * Delete all photos of a specific listing
     * @param  int $ad_id Id of the Listing
     * @return object        Message of success
     */
    public function delete_photos($ad_id) {
        return $this->query_unique("DELETE FROM `carmarket`.`photos`
                                    WHERE (`ad_id` = :ad_id);",
                                    ["ad_id" => $ad_id]);
    }

}
