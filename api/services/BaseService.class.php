<?php

class BaseService{
    protected $dao;

    public function get_by_id($id){
        return $this->dao->get_by_id($id);
    }

    public function add($data){
        return $this->dao->add($data);
    }

    public function delete($token){
        return $this->dao->delete($token);
    }

    public function update($id, $data){
        $this->dao->update($id, $data);
        return $this->dao->get_by_id($id);
    }

    public function checkEmail($email) {
         $find1 = strpos($email, '@');
         $find2 = strpos($email, '.');
         return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }

}
