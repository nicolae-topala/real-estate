<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/services/UserService.class.php";
require_once dirname(__FILE__)."/services/AdvertisementService.class.php";
require_once dirname(__FILE__)."/services/LocationService.class.php";
require_once dirname(__FILE__)."/services/PhotoService.class.php";
require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/users.php";
require_once dirname(__FILE__)."/routes/advertisement.php";
require_once dirname(__FILE__)."/routes/locations.php";
require_once dirname(__FILE__)."/routes/photos.php";

Flight::set('flight.log_errors', TRUE);

/* Error handling for our API *
Flight::map('error', function(Exception $ex){
    Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->getCode() : 500);
});

/**
 * User Services object replacer
 * @example $dao = new UserService(); -> Flight::UserService()
 */
Flight::register('userservice', 'UserService');
Flight::register('advertisementservice', 'AdvertisementService');
Flight::register('locationservice', 'LocationService');
Flight::register('photoservice', 'PhotoService');

/**
 * Utility function for reading query parameters from URL
 * @param name name of paramter
 * @param default_value the default value of the parameter
 */
Flight::map('query', function($name, $default_value = NULL){
    $request = Flight::request();

    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;
    return $query_param;
});

/* utility function for getting header parameters */
Flight::map('header', function($name){
  $headers = getallheaders();
  return @$headers[$name];
});

/* utility function for generating jwt token*/
Flight::map('jwt', function($user){
    $jwt = \Firebase\JWT\JWT::encode(["exp" => (time() + Config::JWT_TOKEN_TIME),
                                      "id" => $user['id'],
                                      "lvl" => $user['admin_level']],
                                      Config::JWT_SECRET);
    return ["token" => $jwt];
});


Flight::route('GET /swagger', function(){
    $openapi = @\OpenApi\scan(dirname(__FILE__)."/routes");
    header('Content-Type: application/json');
    echo $openapi->toJson();
});

Flight::route('GET /', function(){
    Flight::redirect('/docs');
});

Flight::start();

?>
