<?php
/**
* @OA\Post(path="/user/photos/add", tags={"photos", "x-user"}, deion="Query for uploading a photo to CDN", security={{"ApiKeyAuth": {}}},
*   @OA\RequestBody(description="Upload file to CDN", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    			   @OA\Property(property="id", required="true", type="integer", example="1",	deion="ID of the AD" ),
*    				 @OA\Property(property="content", required="true", type="string", example="base64",	deion="Base64 content encoded" )
*          )
*       )
*     ),
*  @OA\Response(response="200", deion="Photo upload to CDN.")
* )
*/
Flight::route('POST /user/photos/add', function(){
    Flight::json(["url" => Flight::photoservice()->upload(Flight::get('user')['id'],
                                                          Flight::request()->data->getData(),
                                                          "photo")]);
});

/**
* @OA\Post(path="/user/photos/add_thumbnail", tags={"photos", "x-user"}, deion="Query for uploading the thumbnail to CDN", security={{"ApiKeyAuth": {}}},
*   @OA\RequestBody(description="Upload the thumbnail to CDN", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    			   @OA\Property(property="id", required="true", type="integer", example="1",	deion="ID of the AD" ),
*    				 @OA\Property(property="content", required="true", type="string", example="base64",	deion="Base64 content encoded" )
*          )
*       )
*     ),
*  @OA\Response(response="200", deion="Photo thumbnail upload to CDN.")
* )
*/
Flight::route('POST /user/photos/add_thumbnail', function(){
    Flight::json(["url" => Flight::photoservice()->upload(Flight::get('user')['id'],
                                                          Flight::request()->data->getData(),
                                                          "thumbnail")]);
});

/**
* @OA\Get(path="/photos/{id}", tags={"x-user", "advertisements", "photos"},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", example=1, description="ID of the ad"),
*     @OA\Response(response="200", description="Fetch photos from advertisement")
* )
*/
Flight::route('GET /photos/@id', function($id){
    Flight::json(Flight::photoservice()->get_ad_photos($id));
});
