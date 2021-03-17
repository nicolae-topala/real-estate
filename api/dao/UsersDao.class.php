<?php

  require_once dirname(__FILE__)."/BaseDao.class.php";

  class UsersDao extends BaseDao{

    public function __construct(){
      parent::__construct("users");
    }

    public function get_user_by_email($email){
      return $this->query_unique("SELECT * FROM users WHERE email = :email", ["email" => $email]);
    }

    public function update_user_by_email($email, $user){
      $this->execute_update("users", $email, $user, "email");
    }

    public function get_users($search, $offset, $limit){
      return $this->query("SELECT * FROM users
                           WHERE LOWER(CONCAT(first_name,' ',last_name)) LIKE CONCAT('%', :name, '%')
                           LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
  }
}
?>
