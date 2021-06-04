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
* @OA\Get(path="/user/publications", tags={"x-user", "user"},  security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(name="offset", type="integer", in="query", default=0, description="Offset for pagination."),
*     @OA\Parameter(name="limit", type="integer", in="query", default=5, description="Limit for pagination."),
*     @OA\Response(response="200", description="Fetch user publications.")
* )
*/
Flight::route('GET /user/publications', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 5);

    Flight::json(Flight::userservice()->get_user_ads(Flight::get('user')['id'], $limit, $offset));
});

/**
* @OA\Get(path="/admin/account/{id}", tags={"x-admin", "user"}, security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1, description="Id of user"),
*     @OA\Response(response="200", description="Fetch individual user as Admin")
* )
*/
Flight::route('GET /admin/account/@id', function($id){
     Flight::json(Flight::userservice()->get_by_id($id));
});

/**
* @OA\Get(path="/account/{id}", tags={"x-user", "user"},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1, description="Id of user"),
*     @OA\Response(response="200", description="Fetch individual user")
* )
*/
Flight::route('GET /account/@id', function($id){
     Flight::json(Flight::userservice()->get_user($id));
});

/**
* @OA\Put(path="/admin/account/{id}", tags={"x-admin", "user"},  security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
*     @OA\RequestBody(description="Basic user info that is going to be updated.", required=true,
*         @OA\MediaType(mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(property="first_name", type="string", example="Nick", description="First name"),
*                 @OA\Property(property="last_name", type="string", example="Ford", description="Last name"),
*                 @OA\Property(property="email", type="string", example="nick.ford@ford.com", description="Email"),
*                 @OA\Property(property="password", type="string", example="example123", description="Password"),
*                 @OA\Property(property="telephone", type="string", example="3248975", description="Telephone"),
*                 @OA\Property(property="status", type="string", example="BLOCKED", description="Change status of account"),
*                 @OA\Property(property="admin_level", type="integer", example="1", description="Make admin")
*             )
*         )
*     ),
*     @OA\Response(response="200", description="Update account as Admin")
* )
*/
Flight::route('PUT /admin/account/@id', function($id){
    Flight::json(Flight::userservice()->update($id, Flight::request()->data->getData()));
});

/**
* @OA\Put(path="/user/account", tags={"x-user", "user"},  security={{"ApiKeyAuth":{}}},
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
Flight::route('PUT /user/account', function(){
    Flight::json(Flight::userservice()->update_info(Flight::get('user')['id'],
                                                    Flight::request()->data->getData()));
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
    Flight::json(Flight::jwt(Flight::userservice()->confirm($token)));
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
    Flight::json(Flight::jwt(Flight::userservice()->login(Flight::request()->data->getData())));
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
    Flight::userservice()->forgot(Flight::request()->data->getData());
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
    Flight::json(Flight::jwt(Flight::userservice()->reset(Flight::request()->data->getData())));
});

/**
* @OA\Get(path="/user/account", tags={"x-user", "user"}, security={{"ApiKeyAuth":{}}},
*     @OA\Response(response="200", description="Fetch individual user")
* )
*/
Flight::route('GET /user/account', function(){
     Flight::json(Flight::userservice()->get_by_id(Flight::get('user')['id']));
});
