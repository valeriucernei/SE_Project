<?php
require_once dirname(__FILE__)."/../config.php";

/**
* The main class for interaction with Data Base.
*
* All other DAO classes should inherit this class.
*
*/
class BaseDao {

    protected $connection;
    private $table;

    public function __construct($table){
        $this->table = $table;
        try {
            $this->connection = new PDO("mysql:host=".Config::DB_HOST().
                                        ";dbname=".Config::DB_SCHEME().
                                        ";port=".Config::DB_PORT(),
                                        Config::DB_USERNAME(),
                                        Config::DB_PASSWORD());

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            throw $e;
        }
    }



}
