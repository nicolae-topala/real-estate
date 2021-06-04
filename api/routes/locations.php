<?php
/**
* @OA\GET(path="/locations", tags={"locations"},
*     @OA\Response(response="200", description="Show all locations")
* )
*/
Flight::route('GET /locations', function(){
    Flight::json(Flight::locationservice()->get_locations());
});
