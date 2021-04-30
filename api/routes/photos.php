<?php
/*SWAGGER documentation*/

/**
* @OA\Get(path="/photos/{token}", tags={"photos"},  description="Query to get photo ID",
*     @OA\Parameter(type="string", in="path", name="token", default="asd123", description="Image token (name)"),
*     @OA\Response(response="200", description="Photo ID")
* )
*/
Flight::route('GET /photos/@token', function($token){
    Flight::json(Flight::photosservice()->get_photo_id($token));
});



/**
* @OA\Get(path="/photos/ad/{id}", tags={"photos"},  description="Query to get all photos of an ad",
*     @OA\Parameter(type="integer", in="path", name="id", default="1", description="Ad ID"),
*     @OA\Response(response="200", description="Photo ID")
* )
*/
Flight::route('GET /photos/ad/@id', function($id){
    Flight::json(Flight::photosservice()->get_ads_photos($id));
});
