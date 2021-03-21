<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once dirname(__FILE__)."/../vendor/autoload.php";
  require_once dirname(__FILE__)."/services/UserService.class.php";
  require_once dirname(__FILE__)."/services/AdvertisementService.class.php";
  require_once dirname(__FILE__)."/routes/users.php";
  require_once dirname(__FILE__)."/routes/advertisement.php";

  /**
   * User Services object replacer
   * @example $dao = new UserService(); -> Flight::UserService()
   */
  Flight::register('userservice', 'UserService');
  Flight::register('advertisementservice', 'AdvertisementService');

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

  Flight::start();

?>
