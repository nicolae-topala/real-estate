<?php
/**
* @OA\Post(path="/advertisement/create", tags={"advertisements"},
*   @OA\RequestBody(deion="Basic advertisement info.", required=true,
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
Flight::route('POST /advertisement/create', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::advertisementservice()->create_ad($data));
});
