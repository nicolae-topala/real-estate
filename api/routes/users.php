<?php

  /**
   * Flight for getting all users
   * @var [type]
   */
  Flight::route('GET /users', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 5);
    $search = Flight::query('search');

    Flight::json(Flight::userservice()->get_users($search, $offset, $limit));
  });


  /**
   * Flight for selecting a specific user by id
   * Using get_by_id method from BaseDao
   */
  Flight::route('GET /users/@id', function($id){
    Flight::json(Flight::userservice()->get_by_id($id));
  });

  /**
   * Flight for Inserting data in DB
   * Using add() method from BaseDao
   */
  Flight::route('POST /users', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userservice()->add($data));
  });

  /**
   * Flight for altering data in DB
   * Using update() and get_by_id() method from BaseDao
   */
  Flight::route('PUT /users/@id', function($id){
    $data = Flight::request()->data->getData();;

    Flight::json(Flight::userservice()->update($id, $data));
  });
