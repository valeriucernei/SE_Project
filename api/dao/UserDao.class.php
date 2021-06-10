<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

/**
 * User's class inheriting BaseDao class
 *
 */
class UserDao extends BaseDao {

    public function __construct() {
        parent::__construct("users");
    }

    /**
     * Method to get user by email
     * @param  string $email User's email address
     * @return object        Object of user's data
     */
    public function get_user_by_email($email) {
        return $this->query_unique("SELECT * FROM users WHERE email = :email",
                                    ["email" => $email]);
    }

    /**
     * Method to ger user by username
     * @param  string $username User's username
     * @return object           Object of user's data
     */
    public function get_user_by_username($username) {
      return $this->query_unique("SELECT * FROM users WHERE username =
                                  :username", ["username" => $username]);
    }

    /**
     * Update user by email
     * @param  string $email User's Email address
     * @param  object $user  User's object
     * @return object        Updated user's object
     */
    public function update_user_by_email($email, $user) {
        $this->update("users", $email, $user, "email");
    }

    /**
     * Get all users
     * @param  string $search username
     * @param  int $offset Offset for users list
     * @param  int $limit  Limit of entries at return
     * @param  string $order  Order for sorting results
     * @return array         array of users
     */
    public function get_users($search, $offset, $limit, $order) {
        list($order_column, $order_direction) = parent::parse_order($order);

        return $this->query("SELECT * FROM users
                            WHERE LOWER(username) LIKE CONCAT('%', :name, '%')
                            ORDER BY ${order_column} ${order_direction}
                            LIMIT ${limit} OFFSET ${offset}",
                            ["name" => strtolower($search)]);
    }

    /**
     * Get user by token
     * @param  string $token user's secret token
     * @return object        Object of user's data
     */
    public function get_user_by_token($token){
        return $this->query_unique("SELECT * FROM users WHERE token = :token",
                                    ["token" => $token]);
    }

}
