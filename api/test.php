<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

  require_once dirname(__FILE__)."/dao/UsersDao.class.php";

  $user_dao = new UsersDao();

  //$user = $user_dao->get_user_by_id("1");

  $user1 = [
    'first_name' => "213",
    'last_name' => "321",
    'password' => "123",
    'email' => "yes",
    'telephone' => "321"
  ];

  $user = $user_dao->add_user($user1);

  print_r($user);



?>
