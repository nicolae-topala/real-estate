<?php
/* Swagger documentation */
/**
* @OA\Info(title="Real-estate API", version="0.1")
* @Oa\OpenApi(
*   @OA\Server(url="http://localhost/real-estate/api/", description="Development Enviroment"),
*   @OA\Server(url="https://real-estate.valerapidarhuisos.md/api/", description="Production Enviroment")
* )
*/

/**
* @OA\Get(path="/users",
*     @OA\Response(response="200", description="List users from database")
* )
*/
Flight::route('GET /users', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 5);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::userservice()->get_users($search, $offset, $limit, $order));
});

/**
* @OA\Get(path="/users/{id}",
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example="1"),
*     @OA\Response(response="200", description="List users from database by id")
* )
*/
Flight::route('GET /users/@id', function($id){
    Flight::json(Flight::userservice()->get_by_id($id));
});

/**
* @OA\Post(path="/users/{id}",
*     @OA\Response(response="200", description="Add an user to database")
* )
*/
Flight::route('POST /users/add', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userservice()->add($data));
});

/**
* @OA\Post(path="/users/register",
*     @OA\Response(response="200", description="Register user to database")
* )
*/
Flight::route('POST /users/register', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userservice()->register($data));
});

/**
* @OA\Get(path="/users/confirm/{token}",
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="token"),
*     @OA\Response(response="200", description="Confirm email by token")
* )
*/
Flight::route('GET /users/confirm/@token', function($token){
    Flight::userservice()->confirm($token);
    Flight::json(["message" => "Your account has been activated."]);
});

/**
* @OA\Put(path="/users/{id}",
*     @OA\Response(response="200", description="Update account")
* )
*/
Flight::route('PUT /users/@id', function($id){
    $data = Flight::request()->data->getData();;

    Flight::json(Flight::userservice()->update($id, $data));
});
