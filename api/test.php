<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

  require_once dirname(__FILE__)."/dao/UsersDao.class.php";

  $user_dao = new UsersDao();

  //$user = $user_dao->get_user_by_id("1");

  $user1 = [
    'first_name' => "Valeras",
    'last_name' => "PIDARAS",
    'email' => "EL ARE",
    'password' => "II FOARTE MARE",
    'telephone' => "IPHONE CONESHO"
  ];

  $user = $user_dao->add_user($user1);



  print_r($user);



?>
