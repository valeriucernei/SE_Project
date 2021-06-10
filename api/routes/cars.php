<?php
/*SWAGGER documentation*/

/**
* @OA\Get(path="/cars/brands", tags={"cars"}, description="Lists all car brands from database (Ex. Mercedes, Audi...)",
*     @OA\Response(response="200", description="Fetch all available car brands")
* )
*/
Flight::route('GET /cars/brands', function() {
    Flight::json(Flight::carsservice()->get_car_brands());
});

/**
* @OA\Get(path="/cars/models/{id}", tags={"cars"}, description="Lists all car models of a specific brand (Ex. Sharan, Golf, Polo)",
*     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", example=1, description="ID of car Brand"),
*     @OA\Response(response="200", description="Fetch all car models of a specific brand")
* )
*/
Flight::route('GET /cars/models/@id', function($id) {
    Flight::json(Flight::carsservice()->get_car_models($id));
});
