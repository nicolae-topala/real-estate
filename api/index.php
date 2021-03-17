<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once dirname(__FILE__)."/../vendor/autoload.php";
  require_once dirname(__FILE__)."/dao/UsersDao.class.php";

  require_once dirname(__FILE__)."/routes/users.php";

  /**
   * UserDao object replacer
   * @example $dao = new UserDao(); -> Flight::userdao()
   */
  Flight::register('userdao', 'UsersDao');

  Flight::route('/', function(){
    echo 'hello world!';
  });

  Flight::start();

?>
