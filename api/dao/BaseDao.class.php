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

    /**
     * Estabilishing connection with Data Base, using specific table for request
     * @param string $table Name of the table for query
     */
    public function __construct($table) {
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

    public function beginTransaction() {
        $response = $this->connection->beginTransaction();
    }

    public function commit() {
        $this->connection->commit();
    }

    public function rollBack() {
        $response = $this->connection->rollBack();
    }

    /**
     * Method for for parsing query sorting order, ASC or DESC
     * @param  string $order String containing sorting requirements
     * @return object        Object ontaining table name for ordering, and direction
     */
    public function parse_order($order) {
        switch(substr($order, 0, 1)) {
            case '-' : $order_direction = "ASC"; break;
            case '+' : $order_direction = "DESC"; break;
            default:
                throw new Exception("Invalid order character. Use either + or -");
            break;
        }

        $order_column = substr($order, 1);

        return [$order_column, $order_direction];
    }

    /**
   * Method for inserting data into database
   * @param string $table  Table name
   * @param object $entity User Data object
   * @return object $entity        Return inserted object with ID
   */
    protected function insert($table, $entity) {
        $query = "INSERT INTO ${table}"."(";
        foreach($entity as $name => $value) {
            $query .= $name.", ";
        }

        $query = substr($query, 0, -2);
        $query .= ") VALUES (";

        foreach($entity as $name => $value) {
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
     * @param  string $table  Table name
     * @param  string $filename File to be deleted
     * @return object         Return the query result
     */
    protected function delete($table, $filename) {
        $stmt = $this->connection->prepare("DELETE FROM ${table} WHERE name = :name");
        $result = $stmt->execute(["name" => $filename]);
        return $result;
    }

    /**
     * Remove Data from Data Base in class table
     * @param  string $filename Name of the file
     * @return object      Return the query result
     */
    public function remove($filename) {
        return $this->delete($this->table, $filename);
    }

    /**
   * Update query in database
   * @param  string  $table     Table name
   * @param  int  $id        Search index (user ID, email...)
   * @param  object $entity    User data
   * @param  string $id_column Optional: Column name (default= 'id')
   * @example update("users", $email, $user, "email");
   */
    protected function execute_update($table, $id, $entity, $id_column = "id") {
        $query = "UPDATE ${table} SET ";

        foreach($entity as $name => $value) {
            $query .= $name." = :".$name.", ";
        }

        $query = substr($query, 0, -2);
        $query .= " WHERE ${id_column} = :id";

        $stmt = $this->connection->prepare($query);

        $entity['id'] = $id;
        $stmt->execute($entity);
    }

    /**
   * Return array with all data regardling query
   * @param string  $query  SQL Query
   * @param object  $params Parameters inside a Query
   * @return object         Return array with all data regardling query
   */
    protected function query($query, $params) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
   * Return unique array regardling query
   * @param  string $query  SQL Query
   * @param  object $params Parameters inside a Query
   * @return object         Return unique array regardling query
   */
    protected function query_unique($query, $params) {
        $results = $this->query($query, $params);
        return reset($results);
    }

    /**
     * Add Data into Data Base in class table
     * @param object  $entity Array of data
     * @return object      Return entry ID
     */
    public function add($entity) {
        return $this->insert($this->table, $entity);
    }

    /**
     * Update existing data  in class table
     * @param int  $id     ID for indexation (Ad ID, user ID...)
     * @param object  $entity Array of data
     */
    public function update($id, $entity) {
        $this->execute_update($this->table, $id, $entity);
    }

    /**
     * Method to get all data from specific table in specific order
     * @param  int $offset Offset integer
     * @param  int $limit  Limit of objects for return
     * @param  string $order  String for sorting data
     * @return object         Object with returned data
     */
    public function get_all($offset, $limit, $order) {
        list($order_column, $order_direction) = self::parse_order($order);

        return $this->query("SELECT * FROM ".$this->table."
                            ORDER BY ${order_column} ${order_direction}
                            LIMIT ${limit} OFFSET ${offset}", []);
    }

    /**
     * Get a specific row from DB by ID
     * @param int  $id ID of the object
     * @return object     Object containing data
     */
    public function get_by_id($id) {
        return $this->query_unique("SELECT * FROM ".$this->table.
                                  " WHERE id = :id", ["id" => $id]);
    }

}
