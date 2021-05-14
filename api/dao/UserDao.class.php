<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("users");
    }

    public function get_user_by_email($email)
    {
        return $this->query_unique("SELECT * FROM users WHERE email = :email",
                                    ["email" => $email]);
    }

    public function get_user_by_username($username)
    {
      return $this->query_unique("SELECT * FROM users WHERE username =
                                  :username", ["username" => $username]);
    }

    public function update_user_by_email($email, $user)
    {
        $this->update("users", $email, $user, "email");
    }

    public function get_users($search, $offset, $limit, $order)
    {
        list($order_column, $order_direction) = parent::parse_order($order);
        return $this->query("SELECT * FROM users
                            WHERE LOWER(username) LIKE CONCAT('%', :name, '%')
                            ORDER BY ${order_column} ${order_direction}
                            LIMIT ${limit} OFFSET ${offset}",
                            ["name" => strtolower($search)]);
    }

    public function get_user_by_token($token)
    {
        return $this->query_unique("SELECT * FROM users WHERE token = :token",
                                    ["token" => $token]);
    }
}
