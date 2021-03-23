<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UsersDao.class.php";

class UserService extends BaseService {
    public function __construct() {
      $this->dao = new UsersDao();
    }

    public function get_users($search, $offset, $limit, $order){
        if ($search){
          return $this->dao->get_users($search, $offset, $limit, $order);
        }else{
          return $this->dao->get_all($offset, $limit, $order);
        }
    }

   public function add($user){
        if(!isset($user['email'])) throw new Exception("Email is missing.");
        $user['status'] = "ACTIVE";

        return parent::add($user);
    }

    public function register($user){
        if(!isset($user['email'])) throw new Exception("Email field is required.");
        if(!isset($user['last_name'])) throw new Exception("Last namefield is required.");
        if(!isset($user['first_name'])) throw new Exception("First name field is required.");
        if(!isset($user['password'])) throw new Exception("Password field is required.");
        if(!isset($user['telephone'])) throw new Exception("Telephone field is required.");

        try{
            $user['token'] = md5(random_bytes(16));
            $user['password'] = md5($user['password']);
            
            return parent::add($user);
        }catch(\Exception $e){
            if(str_contains($e->getMessage(), 'users.uq_user_email')){
                throw new Exception("User with same email (".$user['email'].") already exists in the database", 400, $e);
            }else{
              throw $e;
            }
        }
    }

    public function confirm($token){
        $user = $this->dao->get_user_by_token($token);

        if(!isset($user['id'])) throw new Exception("Invalid Token");

        $this->dao->update($user['id'], ["status" => "ACTIVE", "token" => NULL]);

    }

}
