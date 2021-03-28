<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UsersDao.class.php";
require_once dirname(__FILE__)."/../clients/SMTPClient.class.php";

class UserService extends BaseService {

    private $smtpClient;

    public function __construct() {
      $this->dao = new UsersDao();
      $this->smtpClient = new SMTPClient();
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
        if(!isset($user['last_name'])) throw new Exception("Last name field is required.");
        if(!isset($user['first_name'])) throw new Exception("First name field is required.");
        if(!isset($user['password'])) throw new Exception("Password field is required.");
        if(!isset($user['telephone'])) throw new Exception("Telephone field is required.");

        try{
            $user['token'] = md5(random_bytes(16));
            $user['password'] = md5($user['password']);

            $user = parent::add($user);

        }catch(\Exception $e){
            if(str_contains($e->getMessage(), 'users.uq_user_email')){
                throw new Exception("User with same email (".$user['email'].") already exists in the database", 400, $e);
            }else{
              throw $e;
            }
        }

        $this->smtpClient->send_register_user_token($user);

        return $user;
    }

    public function confirm($token){
        $user = $this->dao->get_user_by_token($token);

        if(!isset($user['id'])) throw new Exception("Invalid Token");

        $this->dao->update($user['id'], ["status" => "ACTIVE", "token" => NULL]);
    }

    public function login($user){
        $db_user = $this->dao->get_user_by_email($user['email']);

        if (!isset($db_user['id'])) throw new Exception("User doesn't exist !", 400);

        switch($db_user['status']){
          case 'PENDING' : throw new Exception("Your account is not confirmed !", 400); break;
          case 'BLOCKED' : throw new Exception("Your account is suspended !", 400); break;
        }

        if(md5($user['password']) != $db_user['password'])
            throw new Exception("Invalid password !", 400);

        return $db_user;
    }

    public function forgot($user){
      $db_user = $this->dao->get_user_by_email($user['email']);

      if (!isset($db_user['id'])) throw new Exception("User doesn't exist !", 400);

      switch($db_user['status']){
        case 'PENDING' : throw new Exception("Your account is not confirmed !", 400); break;
        case 'BLOCKED' : throw new Exception("Your account is suspended !", 400); break;
      }

      $db_user = parent::update($db_user['id'], ['token' => md5(random_bytes(16))]);

      $this->smtpClient->send_user_recovery_token($db_user);
    }

    public function reset($user){
      $db_user = $this->dao->get_user_by_token($user['token']);

      if(!isset($db_user['id'])) throw new Exception("Invalid Token");

      $this->dao->update($db_user['id'], ["password" => md5($user['password']), "token" => NULL]);

    }

}
