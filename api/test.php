<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

  require_once dirname(__FILE__)."/dao/UsersDao.class.php";

  $user_dao = new UsersDao();

  //$user = $user_dao->get_user_by_id("1");

  $user1 = [
    'admin_level' => 1
  ];

  $user = $user_dao->update_user_by_email("valera@valera.com", $user1);



  print_r($user);



?>
