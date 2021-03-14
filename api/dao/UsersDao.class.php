<?php

  require_once dirname(__FILE__)."/BaseDao.class.php";

  class UsersDao extends BaseDao{

    public function get_user_by_email($email){
      return $this->query_unique("SELECT * FROM users WHERE email = :email", ["email" => $email]);
    }

    public function get_user_by_id($id){
      return $this->query_unique("SELECT * FROM users WHERE id = :id", ["id" => $id]);
    }

    public function add_user($user){
      $sql = "INSERT INTO users (first_name, last_name, email, password, telephone) VALUES (:first_name, :last_name, :email, MD5(:password), :telephone)";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute($user);
      $user['id'] = $this->connection->lastInsertId();
      return $user;
    }

    public function update_user($id, $user){
      $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, password = :password, telephone = :telephone, admin_level = :admin_level WHERE id = :id";
      $stmt = $this->connection->prepare($sql);
      $user['id'] = $id;
      $stmt->execute($user);
    }
  }

?>
