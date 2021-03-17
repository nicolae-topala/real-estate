<?php

  /**
   * Flight for getting all users
   * @var [type]
   */
  Flight::route('GET /users', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 5);

    $search = Flight::query('search');
    if ($search){
      Flight::json(Flight::userdao()->get_users($search, $offset, $limit));
    }else{
      Flight::json(Flight::userdao()->get_all($offset, $limit));
    }
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
    $request = Flight::request()->data->getData();
    Flight::json(Flight::userdao()->add($request));
  });

  /**
   * Flight for altering data in DB
   * Using update() and get_by_id() method from BaseDao
   */
  Flight::route('PUT /users/@id', function($id){
    $request = Flight::request();
    $data = $request->data->getData();

    Flight::userdao()->update($id, $data);
    $user = Flight::userdao()->get_by_id($id);
    Flight::json($user);
  });

?>
