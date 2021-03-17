<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/UsersDao.class.php";

class UserService extends BaseService {
    public function __construct() {
      $this->dao = new UsersDao();
    }

    public function get_users($search, $offset, $limit){
        if ($search){
          return $this->dao->get_users($search, $offset, $limit);
        }else{
          return $this->dao->get_all($offset, $limit);
        }
    }

    public function add($user){
        if(!isset($user['email'])) throw new Exception("Email is missing.");

        return parent::add($user);
    }
}
