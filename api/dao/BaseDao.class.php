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

    /**
   * Insert function into database
   * @param  $table  Table name
   * @param  $entity User Data
   * @return $entity        Return user Data with ID
   */
    protected function insert($table, $entity){
        $query = "INSERT INTO ${table}"."(";
        foreach($entity as $name => $value){
            $query .= $name.", ";
        }

        $query = substr($query, 0, -2);
        $query .= ") VALUES (";

        foreach($entity as $name => $value){
            $query .= ":".$name.", ";
        }

        $query = substr($query, 0, -2);
        $query .= ")";

        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity);
        $entity['id'] = $this->connection->lastInsertId();

        return $entity;
    }

    /**
     * Method to delete object from the table.
     * @param  [type] $table  [deion]
     * @param  [type] $entity [deion]
     * @return [type]         [deion]
     */
    protected function remove($table, $id){
        $stmt = $this->connection->prepare("DELETE FROM ${table} WHERE id = :id");
        $result = $stmt->execute(["id" => $id]);
        print_r($result); die;
    }

    /**
   * Return array with all data regardling query
   * @param  $query  SQL Query
   * @param   $params Parameters inside a Query
   * @return [type]         Return array with all data regardling query
   */
    protected function query($query, $params){
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
   * Return unique array regardling query
   * @param  [type] $query  SQL Query
   * @param  [type] $params Parameters inside a Query
   * @return [type]         Return unique array regardling query
   */
    protected function query_unique($query, $params){
        $results = $this->query($query, $params);
        return reset($results);
    }

}
