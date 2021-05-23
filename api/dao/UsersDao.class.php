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

      public function get_users($search, $offset, $limit, $order = "-id"){
          list($order_column, $order_direction) = parent::parse_order($order);

          return $this->query("SELECT * FROM users
                              WHERE LOWER(CONCAT(first_name,' ',last_name)) LIKE CONCAT('%', :name, '%')
                              ORDER BY ${order_column} ${order_direction}
                              LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
      }

      public function get_user_by_token($token){
          return $this->query_unique("SELECT * FROM users
                               WHERE token = :token",["token" => $token]);

      }

      public function get_user_ads($id, $limit, $offset){
          return $this->query("SELECT advertisements.*, descriptions.location_id, descriptions.type_id,
                                      descriptions.rooms, descriptions.floor, descriptions.space,
                                      descriptions.price, descriptions.address, descriptions.text
                               FROM advertisements
                               INNER JOIN descriptions ON advertisements.description_id = descriptions.id
                               INNER JOIN users ON advertisements.admin_id = users.id
                               WHERE admin_id = :id
                               LIMIT ${limit} OFFSET ${offset}",["id" => $id]);
      }

      public function get_user($id){
          return $this->query_unique("SELECT first_name, last_name, email, telephone,
                                      admin_level, status
                               FROM users
                               WHERE id = :id",["id" => $id]);
      }
}
