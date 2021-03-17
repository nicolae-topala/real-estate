<?php

  /**
   * Flight for getting all users
   * @var [type]
   */
  Flight::route('GET /users', function(){
    flight::json(Flight::userdao()->get_all());
  });


  /**
   * Flight for selecting a specific user by id
   * Using get_by_id method from BaseDao
   */
  Flight::route('GET /users/@id', function($id){
    flight::json(Flight::userdao()->get_by_id($id));
  });

  /**
   * Flight for Inserting data in DB
   * Using add() method from BaseDao
   */
  Flight::route('POST /users', function(){
    Flight::json(Flight::userdao()->add(Flight::request()->data->getData()));
  });

  /**
   * Flight for altering data in DB
   * Using update() and get_by_id() method from BaseDao
   */
  Flight::route('PUT /users/@id', function($id){
    Flight::userdao()->update($id, Flight::request()->data->getData());

    flight::json(Flight::userdao()->get_by_id($id));
  });

?>
