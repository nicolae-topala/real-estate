<?php
/* Swagger documentation */
/**
* @OA\Info(title="Real-estate API", version="0.1")
* @Oa\OpenApi(
*   @OA\Server(url="http://localhost/real-estate/api/", description="Development Enviroment"),
*   @OA\Server(url="https://real-estate.studio/api/", description="Production Enviroment")
* )
* @OA\SecurityScheme(
*        securityScheme="ApiKeyAuth",
*        in="header",
*        name="Authentication",
*        type="apiKey"
* )
*/

/**
* @OA\Get(path="/admin/accounts", tags={"x-admin", "user"}, security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination."),
*     @OA\Parameter(type="integer", in="query", name="limit", default=5, description="Limit for pagination."),
*     @OA\Parameter(type="string", in="query", name="search", description="Search string for pagination. Case insensitive search"),
*     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name desceding order by column_name."),
*     @OA\Response(response="200", description="List users from database")
* )
*/
Flight::route('GET /admin/accounts', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 5);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::userservice()->get_users($search, $offset, $limit, $order));
});

/**
* @OA\Get(path="/admin/account/{id}", tags={"x-admin", "user"}, security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1, description="Id of user"),
*     @OA\Response(response="200", description="Fetch individual user")
* )
*/
Flight::route('GET /admin/account/@id', function($id){
     Flight::json(Flight::userservice()->get_by_id($id));
});

/**
* @OA\Put(path="/admin/account/{id}", tags={"x-admin", "user"},  security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
*     @OA\RequestBody(description="Basic user info that is going to be updated.", required=true,
*         @OA\MediaType(mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(property="first_name", type="string", required="true", example="Nick", description="First name"),
*                 @OA\Property(property="last_name", type="string", required="true", example="Ford", description="Last name"),
*                 @OA\Property(property="email", type="string", required="true", example="nick.ford@ford.com", description="Email"),
*                 @OA\Property(property="password", type="string", required="true", example="example123", description="Password"),
*                 @OA\Property(property="telephone", type="string", required="true", example="3248975", description="Telephone")
*             )
*         )
*     ),
*     @OA\Response(response="200", description="Update account.")
* )
*/
Flight::route('PUT /admin/account/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userservice()->update($id, $data));
});

/**
* @OA\Post(path="/register", tags={"login"},
*     @OA\RequestBody(description="Basic user info", required=true,
*         @OA\MediaType(mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(property="first_name", type="string", required="true", example="Nick", description="First name"),
*                 @OA\Property(property="last_name", type="string", required="true", example="Ford", description="Last name"),
*                 @OA\Property(property="email", type="string", required="true", example="nick.ford@ford.com", description="Email"),
*                 @OA\Property(property="password", type="string", required="true", example="example123", description="Password"),
*                 @OA\Property(property="telephone", type="string", required="true", example="3248975", description="Telephone")
*             )
*         )
*     ),
*     @OA\Response(response="200", description="Register user to database")
* )
*/
Flight::route('POST /register', function(){
    Flight::userservice()->register(Flight::request()->data->getData());

    Flight::json(["message" => "Please confirm your account !"]);
});

/**
 * @OA\Get(path="/confirm/{token}", tags={"login"},
 *     @OA\Parameter(type="string", in="path", name="token", default=1, description="Temporary token for activating account"),
 *     @OA\Response(response="200", description="Message upon successfull activation.")
 * )
 */
Flight::route('GET /confirm/@token', function($token){
    Flight::userservice()->confirm($token);
    Flight::json(["message" => "Your account has been activated."]);
});

/**
* @OA\Post(path="/login", tags={"login"},
*     @OA\RequestBody(description="Basic login info", required=true,
*         @OA\MediaType(mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(property="email", type="string", required="true", example="proawp5415@gmail.com", description="Email"),
*                 @OA\Property(property="password", type="string", required="true", example="123", description="Password")
*             )
*         )
*     ),
*     @OA\Response(response="200", description="Login user to site")
* )
*/
Flight::route('POST /login', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userservice()->login($data));
});

/**
* @OA\Post(path="/forgot", tags={"login"},
*     @OA\RequestBody(description="Send recovery URL to users email address", required=true,
*         @OA\MediaType(mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(property="email", type="string", required="true", example="nick.ford@ford.com", description="Email")
*             )
*         )
*     ),
*     @OA\Response(response="200", description="Message that recovery link has been sent.")
* )
*/
Flight::route('POST /forgot', function(){
    $data = Flight::request()->data->getData();
    Flight::userservice()->forgot($data);
    Flight::json(["message" => "Recovery link has been sent to your email"]);
});

/**
* @OA\Post(path="/reset", tags={"login"},
*     @OA\RequestBody(description="Reset user password using recovery token", required=true,
*         @OA\MediaType(mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(property="token", type="string", required="true", example="4134135", description="Recovery token"),
*                 @OA\Property(property="password", type="string", required="true", example="123", description="New password")
*
*             )
*         )
*     ),
*     @OA\Response(response="200", description="Message that user has changed password.")
* )
*/
Flight::route('POST /reset', function(){
    $data = Flight::request()->data->getData();
    Flight::userservice()->reset($data);
    Flight::json(["message" => "Your password has been changed"]);
});

/**
* @OA\Get(path="/user/account", tags={"x-user", "user"}, security={{"ApiKeyAuth":{}}},
*     @OA\Response(response="200", description="Fetch individual user")
* )
*/
Flight::route('GET /user/account', function(){
     Flight::json(Flight::userservice()->get_by_id(Flight::get('user')['id']));
});
