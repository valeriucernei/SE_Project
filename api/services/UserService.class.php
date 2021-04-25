<?php
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UserDao.class.php";
require_once dirname(__FILE__)."/../clients/SMTPClient.class.php";

class UserService extends BaseService{
    private $smtpClient;

    public function __construct(){
        $this->dao = new UserDao();
        $this->smtpClient = new SMTPClient();
    }

    public function get_users($search, $offset, $limit, $order){
        if($search)
            return $this->dao->get_users($search, $offset, $limit, $order);
        else
            return $this->dao->get_all($offset, $limit, $order);
    }

    public function add($user){
        if(!isset($user['username'])) throw new Exception("ERROR! Username is
                                                            missing.");
        $user['status'] = 'ACTIVE';
        return parent::add($user);
    }

    public function register($user){
        if(!isset($user['username']))
            throw new Exception("Username field is required.", 400);
        if(preg_match('/[^A-Za-z0-9]/', $user['username']))
            throw new Exception("Username must have only A-z characters and 0-9
                                  numbers.", 400);
        if(!isset($user['email']))
            throw new Exception("Email field is required.", 400);
        if(!isset($user['fname']))
            throw new Exception("First Name field is required.", 400);
        if(!isset($user['pass']))
            throw new Exception("Password field is required.", 400);
        if(!isset($user['phone']))
            throw new Exception("Phone field is required.", 400);

        $user['pass'] = md5($user['pass']);
        $user['token'] = md5(random_bytes(16));

        try{
            $user = parent::add([
              'username' => $user['username'],
              'fname' => $user['fname'],
              'lname' => isset($user['lname'])  ? $user['lname']  : NULL,
              'pass' => $user['pass'],
              'email' => $user['email'],
              'phone' => $user['phone'],
              'token' => $user['token']
            ]);
        } catch (\Exception $e) {
            if(str_contains($e->getMessage(), 'users.username_UNIQUE'))
                throw new Exception("Account with same username exists in data
                                      base.", 400, $e);
            else if(str_contains($e->getMessage(), 'users.email_UNIQUE'))
                throw new Exception("Account with same email address exists in
                                      data base.", 400, $e);
            else throw $e;
        }
        $this->smtpClient->send_register_user_token($user);
        return $user;
    }

}
