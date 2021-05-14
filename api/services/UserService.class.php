<?php
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UserDao.class.php";
require_once dirname(__FILE__)."/../clients/SMTPClient.class.php";

class UserService extends BaseService
{
    private $smtpClient;

    public function __construct()
    {
        $this->dao = new UserDao();
        $this->smtpClient = new SMTPClient();
    }

    public function get_users($search, $offset, $limit, $order)
    {
        if($search)
            return $this->dao->get_users($search, $offset, $limit, $order);
        else
            return $this->dao->get_all($offset, $limit, $order);
    }

    public function add($user)
    {
        if(!isset($user['username']))
            throw new Exception("ERROR! Username is missing.");

        $user['status'] = 'ACTIVE';
        return parent::add($user);
    }

    public function register($user)
    {
        if(!isset($user['username']))
            throw new Exception("Username field is required.", 400);
        if(preg_match('/[^A-Za-z0-9]/', $user['username']))
            throw new Exception("Username must have only A-z characters and 0-9 numbers.", 400);
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

        try {
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
                throw new Exception("Account with same username exists in data base.", 400, $e);
            else if(str_contains($e->getMessage(), 'users.email_UNIQUE'))
                throw new Exception("Account with same email address exists in data base.", 400, $e);
            else throw $e;
        }
        $this->smtpClient->send_register_user_token($user);

        return $user;
    }

    public function confirm($token)
    {
        $user = $this->dao->get_user_by_token($token);
        if(!isset($user['id']))
            throw new Exception("Invalid token.");

        $this->dao->update($user['id'], [
        "status" => "ACTIVE",
        "token" => NULL
        ]);

        $this->smtpClient->send_confirmed_email($user);

        return $user;
    }

    public function login($user)
    {
        if(parent::checkEmail($user['login']))
            $db_user = $this->dao->get_user_by_email($user['login']);
        else
            $db_user = $this->dao->get_user_by_username($user['login']);

        if(!isset($db_user['id']))
            throw new Exception("User doesn't exist.", 400);
        if($db_user['status'] != 'ACTIVE')
            throw new Exception("Your account has not been yet activated,
                                  or is blocked.", 400);
        if(md5($user['pass']) != $db_user['pass'])
            throw new Exception("You have entered a wrong password.", 400);

        return $db_user;
    }

    public function forgot($user)
    {
        $db_user = $this->dao->get_user_by_email($user['email']);
        if(!isset($db_user['id']))
            throw new Exception("User doesn't exist.", 400);
        if($db_user['status'] != 'ACTIVE')
            throw new Exception("You account has not been yet activated, or is blocked.", 400);

        $time = strtotime(date(config::DATA_FORMAT)) - strtotime($db_user['token_created_at']);
        if( $time < 300 )
          throw new Exception("A new token can be generated in ".(300-$time)." seconds!", 400);

        $db_user = parent::update($db_user['id'], [
            'token' => md5(random_bytes(16)),
            'token_created_at' => date(Config::DATA_FORMAT)]);

        $this->smtpClient->send_recovery_email($db_user);
    }

    public function reset($user)
    {
        $db_user = $this->dao->get_user_by_token($user['token']);
        if(!isset($db_user['id']))
            throw new Exception("Invalid token.");
        if(strtotime(date(config::DATA_FORMAT)) - strtotime($db_user['token_created_at']) > 3600)
            throw new Exception("Reset token expired. Generate a new one.", 400);

        $this->dao->update($db_user['id'], [
            "pass" => MD5($user['pass']),
            "token" => null
        ]);
        return $db_user;
    }

    public function update_info($id, $data)
    {
        $verify = $this->dao->get_by_id($id);
        if(!isset($data['fname']) || strlen($data['fname'])<3)
            $data['fname'] = $verify['fname'];
        if(!isset($data['lname']) || strlen($data['lname'])<3)
            $data['lname'] = $verify['lname'];
        if(!isset($data['email']) || strlen($data['email'])<3)
            $data['email'] = $verify['email'];
        if(!isset($data['phone']) || strlen($data['phone'])<3)
            $data['phone'] = $verify['phone'];
        if(!isset($data['pass']) || strlen($data['pass'])<6)
            $data['pass'] = $verify['pass'];
        else $data['pass'] = md5($data['pass']);

        try {
            return $this->update($id, $data);
        } catch (\Exception $e) {
            if(str_contains($e->getMessage(), 'users.username_UNIQUE'))
                throw new Exception("Account with same username exists in data base.", 400, $e);
            else if(str_contains($e->getMessage(), 'users.email_UNIQUE'))
                throw new Exception("Account with same email address exists in data base.", 400, $e);
            else throw $e;
        }
    }

    public function get_by_id_basic($id)
    {
        $db_user = $this->dao->get_by_id($id);
        $result = [
          'username' => $db_user['username'],
          'fname' => $db_user['fname'],
          'email' => $db_user['email'],
          'phone' => $db_user['phone'],
          'reg_date' => $db_user['reg_date']
        ];
        if(isset($db_user['lname'])) $result['lname'] = $db_user['lname'];
        return $result;
    }
}
