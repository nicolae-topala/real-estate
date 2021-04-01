<?php
/* FILTER BASED MIDDLEWARE*
Flight::before('start', function(&$params, &$output){
    if (Flight::request()->url == '/swagger') return TRUE;

    $headers = getallheaders();
    $token = @$headers['Authentication'];

    try{
        $decoded = (array)\Firebase\JWT\JWT::decode($token, "!IgzGraHsaoWSPc1Orm^u8*pS0sgKQ", array('HS256'));
        Flight::set('user', $decoded);
         return TRUE;
    }catch (\Exception $e){
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
});*/

/* ROUTE BASED MIDDLEWARE */
Flight::route('*', function(){
    if (Flight::request()->url == '/swagger') return TRUE;
    if (Flight::request()->url == '/users/login') return TRUE;


    $headers = getallheaders();
    $token = @$headers['Authentication'];

    try{
        $decoded = (array)\Firebase\JWT\JWT::decode($token, "!IgzGraHsaoWSPc1Orm^u8*pS0sgKQ", array('HS256'));
        Flight::set('user', $decoded);
         return TRUE;
    }catch (\Exception $e){
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
});
