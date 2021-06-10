<?php
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/AdsService.class.php";
require_once dirname(__FILE__)."/../dao/PhotosDao.class.php";
require_once dirname(__FILE__)."/../clients/CDNClient.class.php";

/**
 * Photos Service Class inheriting Base Service Class
 *
 */
class PhotosService extends BaseService {

    private $CDNClient;

    public function __construct() {
        $this->dao = new PhotosDao();
        $this->adsService = new AdsService();
        $this->CDNClient = new CDNClient();
    }

    /**
     * Get all Listing's photos by ID
     * @param  int $id Listing's ID
     * @return array     Array of photos' names and IDs
     */
    public function get_ads_photos($id) {
        $result = $this->dao->get_ads_photos($id);
        return $result;
    }

    /**
     * Delete a specific photo by photo's name
     * @param  object $data Object containing file name
     * @return object    Object with response from server
     */
    public function delete_photo($data) {
        try {
            $this->dao->remove($data['filename']);

        } catch(\Exception $e) {
            throw new Exception("Something went wrong with image "
                                + $data['filename'], 500, $e);
        }

        return $this->CDNClient->delete($data['filename']);
    }

    /**
     * Upload a new photo on Data Base and CDN
     * @param  int $id   ID of the Listing
     * @param  object $data Object with Photo's data
     * @return object    Object of newly uploaded photo on database
     */
    public function upload($id, $data) {
        if($this->adsService->get_ad_by_id($data['id'])['user_id'] != $id)
            throw new Exception("You don't have access to this ad.", 500);
        if(count($this->dao->get_ads_photos($data['id'])) >= 10)
            throw new Exception("Maximum number of photos per ad is 10.", 500);

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $name = substr(str_shuffle($permitted_chars), 0, 16).'.png';

        try {
            parent::add([
                'ad_id' => $data['id'],
                'name' => $name
            ]);
        } catch(\Exception $e) {
            throw new Exception("Something went wrong with images upload.", 500, $e);
        }

        return $this->CDNClient->upload($name, $data['content']);
    }

}
