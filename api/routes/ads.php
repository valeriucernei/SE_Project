<?php
/* SWAGGER documentation */

/**
* @OA\Get(path="/listings", tags={"listings"}, description="List all ads from database",
*     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
*     @OA\Parameter(type="integer", in="query", name="limit", default=15, description="Limit the number of results"),
*     @OA\Parameter(type="string", in="query", name="search", description="Search string for accounts (Case insensitive search)"),
*     @OA\Parameter(type="string", in="query", name="order", default="-ads.id", description="Sorting for return elements -column_name ascending, or +column_name descending"),
*     @OA\Parameter(type="integer", in="query", name="user_id", default=null, description="ID of the user who created the ad"),
*     @OA\Parameter(type="integer", in="query", name="brand", default=null, description="ID of car Brand"),
*     @OA\Parameter(type="integer", in="query", name="model", default=null, description="ID of car Model"),
*     @OA\Parameter(type="integer", in="query", name="car_body", default=null, description="Car Body number"),
*     @OA\Parameter(type="integer", in="query", name="fabricated_min", default=1970, description="Minimal year of fabrication"),
*     @OA\Parameter(type="integer", in="query", name="fabricated_max", default=2021, description="Maximum year of fabrication"),
*     @OA\Parameter(type="integer", in="query", name="km_min", default=0, description="Minimum mileage"),
*     @OA\Parameter(type="integer", in="query", name="km_max", default=1000000, description="Maximum mileage"),
*     @OA\Parameter(type="integer", in="query", name="price_min", default=0, description="Minimal price"),
*     @OA\Parameter(type="integer", in="query", name="price_max", default=1000000, description="Maximum price"),
*     @OA\Parameter(type="integer", in="query", name="gearbox", default=null, description="Gearbox type number"),
*     @OA\Parameter(type="integer", in="query", name="fuel_type", default=null, description="Fuel type number"),
*     @OA\Parameter(type="integer", in="query", name="motor_size_min", default=0, description="Minimal motor size"),
*     @OA\Parameter(type="integer", in="query", name="motor_size_max", default=100000, description="Maximum motor size"),
*     @OA\Response(response="200", description="Lists ads from database")
* )
*/
Flight::route('GET /listings', function() {
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    $order = Flight::query('order', "-ads.id");
    $user_id = Flight::query('user_id');
    $brand = Flight::query('brand');
    $model = Flight::query('model');
    $car_body = Flight::query('car_body');
    $fabricated_min = Flight::query('fabricated_min', 1970);
    $fabricated_max = Flight::query('fabricated_max', date("Y"));
    $km_min = Flight::query('km_min', 0);
    $km_max = Flight::query('km_max', 1000000);
    $price_min = Flight::query('price_min', 0);
    $price_max = Flight::query('price_max', 1000000);
    $gearbox = Flight::query('gearbox');
    $fuel_type = Flight::query('fuel_type');
    $motor_size_min = Flight::query('motor_size_min',0);
    $motor_size_max = Flight::query('motor_size_max',10000);
    Flight::json(Flight::adsservice()->get_ads($search, $offset, $limit, $order,
    $user_id, $brand, $model, $car_body, $fabricated_min, $fabricated_max, $km_min, $km_max,
    $price_min, $price_max, $gearbox, $fuel_type, $motor_size_min, $motor_size_max));
});

/**
* @OA\Get(path="/listings/{id}", tags={"listings"},  description="Query to get ad info by ID",
*     @OA\Parameter(type="integer", in="path", name="id", default="1", description="Ad ID"),
*     @OA\Response(response="200", description="Fetched ad info")
* )
*/
Flight::route('GET /listings/@id', function($id) {
    flight::json(Flight::adsservice()->get_ad_by_id($id));
});

/**
* @OA\Post(path="/user/listings/add", tags={"x-user", "listings"}, description="Query for users to add a new ad", security={{"ApiKeyAuth": {}}},
*   @OA\RequestBody(description="Basic Adv Info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				 @OA\Property(property="title", required="true", type="string", example="Advertisement Title",	description="Advertisement's Title" ),
*    				 @OA\Property(property="description", type="string", example="Best car EVER!",	description="Advertisement's Description" ),
*    				 @OA\Property(property="model", required="true", type="integer", example="7",	description="Car Model Number from Data Base" ),
*    				 @OA\Property(property="car_body", required="true", type="integer", example="4",	description="Car Body Number from Data Base" ),
*    				 @OA\Property(property="fabricated", required="true", type="integer", example="2019",	description="Car fabrication year" ),
*    				 @OA\Property(property="km", type="integer", example="49000",	description="Car mileage" ),
*    				 @OA\Property(property="price", type="integer", example="112000",	description="Car's price" ),
*    				 @OA\Property(property="gearbox", type="integer", example="2",	description="Gearbox number" ),
*    				 @OA\Property(property="fuel_type", type="integer", example="1",	description="Fuel Type Number" ),
*    				 @OA\Property(property="motor_size", type="integer", example="2400",	description="Motor size in cm" )
*          )
*       )
*     ),
*  @OA\Response(response="200", description="Ad that has been added into database with ID assigned.")
* )
*/
Flight::route('POST /user/listings/add', function() {
    Flight::json(Flight::adsservice()->add_ad(Flight::get('user'), Flight::request()->data->getData()));
});

/**
 * @OA\Put(path="/user/listings/{id}", tags={"x-user", "listings"}, description="Query for users to edit one of their ad", security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *   @OA\RequestBody(description="Advertise info updater.", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="title", required="true", type="string", example="Lada Mustang",	description="Advertisement's title" ),
 *    				 @OA\Property(property="description", type="string", example="Best car Ever!",	description="Advertisement's description" ),
 *    				 @OA\Property(property="model", type="string", example="11",	description="Car Model number" ),
 *    				 @OA\Property(property="car_body", required="true", type="integer", example="2",	description="Car Body Number" ),
 *    				 @OA\Property(property="fabricated", required="true", type="integer", example="2019",	description="Car Year of fabrication" ),
 *    				 @OA\Property(property="km", type="integer", example="125000",	description="Car's mileage" ),
 *    				 @OA\Property(property="price", type="integer", example="10000",	description="Car's price" ),
 *    				 @OA\Property(property="gearbox", type="integer", example="1",	description="Car's gearbox type number" ),
 *    				 @OA\Property(property="fuel_type", type="integer", example="1",	description="Car's fuel type number" ),
 *    				 @OA\Property(property="motor_size", type="integer", example="2400",	description="Motor size in cm" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update account based on id")
 * )
 */
Flight::route('PUT /user/listings/@id', function($id) {
    Flight::json(Flight::adsservice()->update_user_ad(Flight::get('user')['id'], $id, Flight::request()->data->getData()));
});

/**
 * @OA\Put(path="/admin/listings/{id}", tags={"x-admin","listings"}, description="Query for Admins, to edit any ad in the system", security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *   @OA\RequestBody(description="Advertise info updater.", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="title", required="true", type="string", example="Lada Mustang",	description="Advertisement's title" ),
 *    				 @OA\Property(property="description", type="string", example="Best car Ever!",	description="Advertisement's description" ),
 *    				 @OA\Property(property="model", type="string", example="11",	description="Car Model number" ),
 *    				 @OA\Property(property="car_body", required="true", type="integer", example="2",	description="Car Body Number" ),
 *    				 @OA\Property(property="fabricated", required="true", type="integer", example="2019",	description="Car Year of fabrication" ),
 *    				 @OA\Property(property="km", type="integer", example="125000",	description="Car's mileage" ),
 *    				 @OA\Property(property="price", type="integer", example="10000",	description="Car's price" ),
 *    				 @OA\Property(property="gearbox", type="integer", example="1",	description="Car's gearbox type number" ),
 *    				 @OA\Property(property="fuel_type", type="integer", example="1",	description="Car's fuel type number" ),
 *    				 @OA\Property(property="motor_size", type="integer", example="2400",	description="Motor size in cm" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update account based on id")
 * )
 */
Flight::route('PUT /admin/listings/@id', function($id) {
    Flight::json(Flight::adsservice()->update_ad($id, Flight::request()->data->getData()));
});

/**
* @OA\Get(path="/user/listings/verify/{ad_id}", tags={"x-user", "listings"}, security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", type="integer", name="ad_id", example=1, deion="ID of the ad"),
*     @OA\Response(response="200", deion="Fetch individual advertisement")
* )
*/
Flight::route('GET /user/listings/verify/@ad_id', function($ad_id) {
    Flight::json(Flight::adsservice()->verify_ad_user(Flight::get('user')['id'], $ad_id));
});

/**
* @OA\Get(path="/user/listings/delete/{ad_id}", tags={"x-user", "listings"}, security={{"ApiKeyAuth":{}}},
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", type="integer", name="ad_id", example=1, deion="ID of the ad"),
*     @OA\Response(response="200", deion="Success! Ad deleted.")
* )
*/
Flight::route('GET /user/listings/delete/@ad_id', function($ad_id) {
    Flight::json(Flight::adsservice()->delete_ad(Flight::get('user')['id'], $ad_id));
});
