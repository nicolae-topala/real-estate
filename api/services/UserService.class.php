<?php

require_once dirname(__FILE__)."/../dao/UsersDao.class.php";

class UserService {

    private $dao;

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
}
