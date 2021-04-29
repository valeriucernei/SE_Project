<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/../vendor/autoload.php";
require_once dirname(__FILE__)."/services/UserService.class.php";
require_once dirname(__FILE__)."/services/AdsService.class.php";
require_once dirname(__FILE__)."/services/CarsService.class.php";
require_once dirname(__FILE__)."/services/PhotosService.class.php";

Flight::set('flight.log_errors', True);

/* error handling for our API */
Flight::map('error', function(Exception $ex){
    Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->GetCode() : 500);
});

/* utility function for reading query parameters from URL */
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

/* utility function for getting jwt token */
Flight::map('jwt', function($user){
  $jwt = \Firebase\JWT\JWT::encode([
      "exp" => (time() + Config::JWT_TOKEN_TIME),
      "id" => $user['id'],
      "usr" => $user['username'],
      "adm" => $user['admin']], Config::JWT_SECRET);
  return ['token' => $jwt];
});

/* List of available query requests in JSON format*/
Flight::route('GET /swagger', function(){
    $openapi = @\OpenApi\scan(dirname(__FILE__)."/routes");
    header('Content-Type: application/json');
    echo $openapi->toJson();
});

/* Redirect from /api to /api/docs */
Flight::route('GET /', function(){
    Flight::redirect('/docs');
});

/* register Business Logic layer services */
Flight::register("userservice","UserService");
Flight::register("adsservice","AdsService");
Flight::register("carsservice","CarsService");
Flight::register("photosservice","PhotosService");

/* include all routes */
require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/users.php";
require_once dirname(__FILE__)."/routes/ads.php";
require_once dirname(__FILE__)."/routes/cars.php";
require_once dirname(__FILE__)."/routes/photos.php";

Flight::start();
