<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

/*  require_once dirname(__FILE__)."/dao/UsersDao.class.php";

  $user_dao = new UsersDao();

  //$user = $user_dao->get_user_by_id("1");

  $user1 = [
    'first_name' => "213",
    'last_name' => "321",
    'password' => "123",
    'email' => "lol",
    'telephone' => "dsadas"
  ];

  $user = $user_dao->add_user($user1);

  print_r($user);
*/

 require_once dirname(__FILE__)."/dao/AdvertisementsDao.class.php";

$advertisement_dao = new AdvertisementsDao();

$advertisement_dao->update(3,[
  'admin_id' => 1,
  'name' => "hello",
  'address' => "no address"
]);
  //$advertisement = $advertisement_dao->update(1,$advertisement1);

  print_r($advertisement_dao);

?>
