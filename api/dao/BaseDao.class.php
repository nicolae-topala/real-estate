<?php
  require_once dirname(__FILE__)."/../config.php";

  /**
  * The main class for interaction with database.
  *
  * All other DAO classes should inherit this class.
  *
  */

class BaseDao{

  protected $connection;
  private $table;

  public function __construct($table){
    $this->table = $table;
    try {
      $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_SCHEME, Config::DB_USERNAME, Config::DB_PASSWORD);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //$this->connection->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
    } catch(PDOException $e) {
      throw $e;
    }
  }

  public function beginTransaction(){
      $response = $this->connection->beginTransaction();
  }

  public function commit(){
      $this->connection->commit();
  }

  public function rollBack(){
      $response = $this->connection->rollBack();
  }

  public function parse_order($order){
        switch(substr($order, 0, 1)){
            case '-' : $order_direction = "ASC"; break;
            case '+' : $order_direction = "DESC"; break;
            default: throw new Exception("Invalid order format, first character should be either + or -");
        }

        $order_column = substr($order, 1);
        return [$order_column, $order_direction];
  }

  /**
   * Insert query for DB
   * @param  $table  Table name
   * @param  $entity User data
   * @return User_data         Return the user data + the id it created for it.
   */
  protected function insert($table, $entity){
    $query = "INSERT INTO ${table} "."(";
      foreach($entity as $name => $value){
        $query .= $name.", ";
      }
      $query = substr($query, 0 , -2);
      $query .= ") VALUES (";
      foreach($entity as $name => $value){
        $query .= ":${name}, ";
      }
      $query = substr($query, 0 , -2);
      $query .= ")";

    $stmt = $this->connection->prepare($query);
    $stmt->execute($entity);
    $entity['id'] = $this->connection->lastInsertId();
    return $entity;
  }

  /**
   * Update query for DB
   * @param  $table     Table name
   * @param  $id        Search value
   * @param  $entity    User data
   * @param  $id_column Optional: Search by column name(default: id)
   * @example $this->update("users", $email, $user, "email"); in which $user = $user_dao->update_user_by_email("valera@valera.com", $user1);
   */
  protected function execute_update($table, $id, $entity, $id_column = "id"){
    $query = "UPDATE ${table} SET ";
    foreach($entity as $name => $value){
      $query .=$name. " = :" .$name. ", ";
    }
    $query = substr($query, 0 , -2);
    $query .=" WHERE ${id_column} = :id";

    $stmt = $this->connection->prepare($query);
    $entity['id'] = $id;
    $stmt->execute($entity);

    return $entity;
  }

  /**
   * Return array of arrays data
   * @param  string $query  The querry command of select
   * @param  $params The parametres from the query
   * @return [type]         Returns array of arrays data
   */
  protected function query($query, $params){
    $stmt = $this->connection->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Return single array data
   * @param  string $query  The querry command of select
   * @param  $params The parametres from the query
   * @return [type]         Returns single array data
   */
  protected function query_unique($query, $params){
    $results = $this->query($query, $params);
    return reset($results);
  }

  /**
   * Add function for DB
   * @param $entity Array of data, example
   */
  public function add($entity){
    return $this->insert($this->table,$entity);
  }

  /**
   * Update function for DB
   * @param   $id     Id of data from which it will do the update
   * @param   $entity Data array which will be updated
   */
  public function update($id,$entity){
    $result = $this->execute_update($this->table, $id, $entity);

    return $result;
  }

  /**
   * Get array of data by id
   * @param   $id Id to search
   * @return Single_Array     Single array of data
   */
  public function get_by_id($id){
    return $this->query_unique("SELECT * FROM ".$this->table." WHERE id = :id", ["id" => $id]);
  }

  /**
   * Get all data from a table
   */
  public function get_all($offset, $limit, $order){
      list($order_column, $order_direction) = self::parse_order($order);

      return $this->query("SELECT * FROM ".$this->table."
                          ORDER BY ${order_column} ${order_direction}
                          LIMIT ${limit} OFFSET ${offset}", []);
  }
}

?>
