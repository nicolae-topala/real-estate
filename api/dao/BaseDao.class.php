<?php
  require_once dirname(__FILE__)."/../config.php";

class BaseDao{

  protected $connection;

  public function __construct(){
    try {
      $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_SCHEME, Config::DB_USERNAME, Config::DB_PASSWORD);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      throw $e;
    }
  }

  public function insert($table, $entity){
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
  public function update($table, $id, $entity, $id_column = "id"){
    $query = "UPDATE ${table} SET ";
    foreach($entity as $name => $value){
      $query .=$name. " = :" .$name. ", ";
    }
    $query = substr($query, 0 , -2);
    $query .=" WHERE ${id_column} = :id";

    $stmt = $this->connection->prepare($query);
    $entity['id'] = $id;
    $stmt->execute($entity);
  }

  public function query($query, $params){
    $stmt = $this->connection->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function query_unique($query, $params){
    $results = $this->query($query, $params);
    return reset($results);
  }


}

?>
