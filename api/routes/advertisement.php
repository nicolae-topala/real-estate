<?php

/**
* @OA\GET(path="/advertisement", tags={"advertisements"},
*     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination."),
*     @OA\Parameter(type="integer", in="query", name="limit", default=5, description="Limit for pagination."),
*     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name desceding order by column_name."),
*    	@OA\Parameter(name="title", type="string", in="query", example="Title", default="",	description="Advertisement's title."),
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
*     @OA\Response(response="200", description="Create advertisement")
* )
*/
Flight::route('GET /advertisements', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 5);
    $title = Flight::query('title', "%");
    $order = Flight::query('order', "-id");
    $floors_min = Flight::query('floors_min', 0);
    $floors_max = Flight::query('floors_max', 100);
    $price_min = Flight::query('price_min', 0);
    $price_max = Flight::query('price_max', 9999999);
    $location = Flight::query('location');
    $type = Flight::query('type');
    $space_min = Flight::query('space_min', 0);
    $space_max = Flight::query('space_max', 9999999);
    $rooms_min = Flight::query('rooms_min', 0);
    $rooms_max = Flight::query('rooms_max', 9999999);
    $address = Flight::query('address', "%");

    Flight::json(Flight::advertisementservice()->get_advertisements($title, $offset, $limit, $order, $floors_min, $floors_max, $price_min, $address,
                                                                    $price_max, $location, $type, $space_min, $space_max, $rooms_min, $rooms_max));
});

/**
* @OA\Post(path="/advertisement/create", tags={"advertisements"},
*   @OA\RequestBody(description="Basic advertisement info.", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				 @OA\Property(property="admin_id", required="true", type="integer", example=1,	description="Admin Id that created the post."),
*    				 @OA\Property(property="title", required="true", type="string", example="Title",	description="Advertisement's title."),
*    				 @OA\Property(property="description_id", required="true", type="integer", example=1,	description="Description ID, with all the attributes there." ),
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
*  @OA\Response(response="200", description="Create advertisement")
* )
*/
Flight::route('POST /advertisements/create', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::advertisementservice()->create_ad($data));
});

/**
* @OA\Put(path="/users/{id}", tags={"user"},
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
Flight::route('PUT /advertisements/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::advertisementservice()->update($id, $data));
});
