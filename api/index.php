<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require dirname(__FILE__)."/../vendor/autoload.php";
  require dirname(__FILE__)."/dao/UsersDao.class.php";

  Flight::register('userdao', 'UsersDao');

  Flight::route('/', function(){
    echo 'hello world!';
  });

  Flight::route('GET /users', function(){
    flight::json(Flight::userdao()->get_all());
  });

  Flight::route('GET /users/@id', function($id){
    flight::json(Flight::userdao()->get_by_id($id));
  });

  Flight::route('POST /users', function(){
    Flight::json(Flight::userdao()->add(Flight::request()->data->getData()));
  });

  Flight::route('PUT /users/@id', function($id){
    Flight::userdao()->update($id, Flight::request()->data->getData());

    flight::json(Flight::userdao()->get_by_id($id));
  });

  Flight::start();
?>
