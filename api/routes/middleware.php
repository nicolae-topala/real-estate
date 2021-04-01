<?php
Flight::route('/user/*', function(){
    try{
        $user = (array)\Firebase\JWT\JWT::decode($token, Config::JWT_SECRET, array('HS256'));

        if(Flight::request()->method != GET && $user["lvl"] == -1){
            throw new Exception("You do not have permission to do this !", 403);
        }

        Flight::set('user', $user);;
        return TRUE;
    }catch (\Exception $e){
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
});

Flight::route('/admin/*', function(){
    try{
        $user = (array)\Firebase\JWT\JWT::decode($token, Config::JWT_SECRET, array('HS256'));

        if($user['lvl'] < 1){
            throw new Exception("Admin access required.", 403);
        }
        
        Flight::set('user', $user);
        return TRUE;
    }catch (\Exception $e){
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
});
