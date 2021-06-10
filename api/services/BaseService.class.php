<?php

/**
 * Base Service class
 * 
 */
class BaseService {

    protected $dao;

    /**
     * Get something by ID
     * @param  int $id Id of the requested object
     * @return object     Object with data
     */
    public function get_by_id($id) {
        return $this->dao->get_by_id($id);
    }

    /**
     * Add new registry in Data Base
     * @param object $data Object with data
     * @return object     Object with new added data
     */
    public function add($data) {
        return $this->dao->add($data);
    }

    /**
     * Delete a registry from Data Base
     * @param  string $token Token
     * @return object     Object with success mesage after deleting
     */
    public function delete($token) {
        return $this->dao->delete($token);
    }

    /**
     * Update an entry in Data Base
     * @param  int $id   ID of the object to update
     * @param  object $data New data to be assigned to the object
     * @return object       Updated object data
     */
    public function update($id, $data) {
        $this->dao->update($id, $data);
        return $this->dao->get_by_id($id);
    }

    /**
     * Check if a specific email address is valid
     * @param  string $email Email Address
     * @return bool        True if the stirng is an valid email
     */
    public function checkEmail($email) {
         $find1 = strpos($email, '@');
         $find2 = strpos($email, '.');
         return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }

}
