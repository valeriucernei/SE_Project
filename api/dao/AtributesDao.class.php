<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

/**
 * Class for Listings atribute
 * 
 */
class AtributesDao extends BaseDao {

    public function __construct() {
        parent::__construct("atributes");
    }

    /**
     * Method ID of a listing's atributes
     * @param  int $id ID of the Listing
     * @return object     Object containing the ID
     */
    public function get_atributes_id($id) {
        return $this->query_unique("SELECT id FROM atributes
                                    WHERE ad_id = :id", ["id" => $id]);
    }

    /**
     * Delete the Listing's attributes
     * @param  int $ad_id ID of the Listing
     * @return object        Confirmation message
     */
    public function delete_atributes($ad_id) {
        return $this->query_unique("DELETE FROM `carmarket`.`atributes`
                                    WHERE (`ad_id` = :ad_id);",
                                    ["ad_id" => $ad_id]);
    }

}
