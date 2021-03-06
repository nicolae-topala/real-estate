<?php
/**
* @OA\GET(path="/publications", tags={"x-user", "publications"},
*     @OA\Parameter(name="offset", type="integer", in="query", default=0, description="Offset for pagination."),
*     @OA\Parameter(name="limit", type="integer", in="query", default=5, description="Limit for pagination."),
*     @OA\Parameter(name="order", type="string", in="query", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name desceding order by column_name."),
*    	@OA\Parameter(name="title", type="string", in="query", example="Title", default="",	description="Publication's title."),
*     @OA\Parameter(name="address", type="string", in="query", example="Manhatan street 2", default="",	description="The address."),
*     @OA\Parameter(name="location_id", type="integer", in="query", example=1, description="Location ID from Locations Table."),
*     @OA\Parameter(name="type_id", type="integer", in="query", example=1, description="Type ID from Types Table."),
*     @OA\Parameter(name="price_min", type="integer", in="query", example=1, default=0,	description="Minimun price."),
*     @OA\Parameter(name="price_max", type="integer", in="query", example=9999999, default=9999999,	description="Maximum price."),
*     @OA\Parameter(name="floor_min", type="integer", in="query", example=0, default=0,	description="Minimun floor number."),
*     @OA\Parameter(name="floor_max", type="integer", in="query", example=69, default=100,	description="Maximum floor number."),
*     @OA\Parameter(name="space_min", type="integer", in="query", example=1, default=0,	description="Minimun the ammount of space in m2."),
*     @OA\Parameter(name="space_max", type="integer", in="query", example=300, default=9999999,	description="Maximum the ammount of space in m2."),
*     @OA\Parameter(name="rooms_min", type="integer", in="query", example=1, default=0,	description="Minimun number of rooms."),
*     @OA\Parameter(name="rooms_max", type="integer", in="query", example=12, default=9999999,	description="Maximum number of rooms."),
*     @OA\Response(response="200", description="Create publication")
* )
*/
Flight::route('GET /publications', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 5);
    $title = Flight::query('title', "%");
    $order = Flight::query('order', "-id");
    $floors_min = Flight::query('floors_min', 0);
    $floors_max = Flight::query('floors_max', 100000);
    $price_min = Flight::query('price_min', 0);
    $price_max = Flight::query('price_max', 9999999);
    $location_id = Flight::query('location_id');
    $type_id = Flight::query('type_id');
    $space_min = Flight::query('space_min', 0);
    $space_max = Flight::query('space_max', 9999999);
    $rooms_min = Flight::query('rooms_min', 0);
    $rooms_max = Flight::query('rooms_max', 9999999);
    $address = Flight::query('address', "%");

    Flight::json(Flight::advertisementservice()->get_advertisements($title, $offset, $limit, $order, $floors_min, $floors_max, $price_min, $address,
                                                                    $price_max, $location_id, $type_id, $space_min, $space_max, $rooms_min, $rooms_max));
});

/**
* @OA\GET(path="/publications/profile/{user_id}", tags={"x-user", "publications"},
*     @OA\Parameter(name="offset", type="integer", in="query", default=0, description="Offset for pagination."),
*     @OA\Parameter(name="limit", type="integer", in="query", default=5, description="Limit for pagination."),
*     @OA\Parameter(name="order", type="string", in="query", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name desceding order by column_name."),
*     @OA\Parameter(name="user_id", type="integer", in="path", example=1, description="User ID that owns the ADS."),
*     @OA\Response(response="200", description="ADs from a specific user")
* )
*/
Flight::route('GET /publications/profile/@user_id', function($user_id){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 5);
    $order = Flight::query('order', "-id");

    Flight::json(Flight::advertisementservice()->get_user_advertisements($offset, $limit, $user_id, $order));
});

/**
* @OA\Get(path="/publications/{id}", tags={"x-user", "publications"},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", example=1, description="ID of the ad"),
*     @OA\Response(response="200", description="Fetch individual publication")
* )
*/
Flight::route('GET /publications/@id', function($id){
    Flight::json(Flight::advertisementservice()->get_ad_by_id($id));
});

/**
* @OA\Get(path="/user/publications/verify/{ad_id}", tags={"x-user", "publications"}, security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", type="integer", name="ad_id", example=1, description="ID of the ad"),
*     @OA\Response(response="200", description="Verify if the user is the owner of the AD")
* )
*/
Flight::route('GET /user/publications/verify/@ad_id', function($ad_id){
    Flight::json(Flight::advertisementservice()->verify_ad_user(Flight::get('user')['id'],
                                                                $ad_id));
});

/**
* @OA\Delete(path="/user/publications/{ad_id}", tags={"x-user", "publications"}, security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", type="integer", name="ad_id", example=1, description="ID of the ad"),
*     @OA\Response(response="200", description="Delete publications from DB.")
* )
*/
Flight::route('DELETE /user/publications/@ad_id', function($ad_id){
    Flight::json(Flight::advertisementservice()->delete_ad(Flight::get('user'), $ad_id));
});

/**
* @OA\Post(path="/user/publications/create", tags={"x-user", "publications"}, security={{"ApiKeyAuth":{}}},
*   @OA\RequestBody(description="Basic publication info.", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				 @OA\Property(property="title", required="true", type="string", example="Title",	description="Publication's title."),
*            @OA\Property(property="address", required="true", type="string", example="Manhatan street 2",	description="The address."),
*            @OA\Property(property="location_id", required="true", type="integer", example=1,	description="Location ID from Locations Table."),
*            @OA\Property(property="type_id", required="true", type="integer", example=1,	description="Type ID from Types Table."),
*            @OA\Property(property="price", required="true", type="integer", example=123,	description="Price."),
*            @OA\Property(property="floor", type="integer", example=1,	description="Floor number."),
*            @OA\Property(property="space", type="integer", example=12,	description="The ammount of space in m2."),
*            @OA\Property(property="rooms", type="integer", example=2,	description="Number of rooms."),
*            @OA\Property(property="text",  type="string", example="This is a text.",	description="Description text.")
*          )
*       )
*     ),
*  @OA\Response(response="200", description="Create publication")
* )
*/
Flight::route('POST /user/publications/create', function(){
    Flight::json(Flight::advertisementservice()->create_ad(Flight::get('user'),
                                                           Flight::request()->data->getData()));
});

/**
* @OA\Put(path="/admin/publications/{id}", tags={"x-admin", "publications"}, security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
*     @OA\RequestBody(description="Basic publication info that is going to be updated.", required=true,
*         @OA\MediaType(mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(property="title", type="string", example="House title", description="The title of the ad"),
*                 @OA\Property(property="address", type="string", example="Human street nr.3", description="The street number of the ad"),
*                 @OA\Property(property="location_id", type="integer", example="1", description="The id that includes the location"),
*                 @OA\Property(property="type_id", type="integer", example="1", description="The type of the ad"),
*                 @OA\Property(property="price", type="integer", example="2500", description="Price number"),
*                 @OA\Property(property="floor", type="integer", example="4", description="Floor number"),
*                 @OA\Property(property="space", type="integer", example="53", description="Space number in m2"),
*                 @OA\Property(property="rooms", type="integer", example="2", description="Number of rooms"),
*                 @OA\Property(property="text", type="string", example="This is a text.", description="The description, max 1000 characters")
*             )
*         )
*     ),
*     @OA\Response(response="200", description="Update AD as Admin.")
* )
*/
Flight::route('PUT /admin/publications/@id', function($id){
    Flight::json(Flight::advertisementservice()->modify_ad($id, Flight::request()->data->getData(),
                                                           Flight::get('user')));
});

/**
* @OA\Put(path="/user/publications/{id}", tags={"x-user", "publications"}, security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
*     @OA\RequestBody(description="Basic publication info that is going to be updated.", required=true,
*         @OA\MediaType(mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(property="title", type="string", example="House title", description="The title of the ad"),
*                 @OA\Property(property="address", type="string", example="Human street nr.3", description="The street number of the ad"),
*                 @OA\Property(property="location_id", type="integer", example="1", description="The id that includes the location"),
*                 @OA\Property(property="type_id", type="integer", example="1", description="The type of the ad"),
*                 @OA\Property(property="price", type="integer", example="2500", description="Price number"),
*                 @OA\Property(property="floor", type="integer", example="4", description="Floor number"),
*                 @OA\Property(property="space", type="integer", example="53", description="Space number in m2"),
*                 @OA\Property(property="rooms", type="integer", example="2", description="Number of rooms"),
*                 @OA\Property(property="text", type="string", example="This is a text.", description="The description, max 1000 characters")
*             )
*         )
*     ),
*     @OA\Response(response="200", description="Update account as Admin.")
* )
*/
Flight::route('PUT /user/publications/@id', function($id){
    Flight::json(Flight::advertisementservice()->modify_user_ad($id, Flight::request()->data->getData(),
                                                                Flight::get('user')));
});
