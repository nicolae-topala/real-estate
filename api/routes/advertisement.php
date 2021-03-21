<?php

  /**
   * Flight for Inserting data in DB
   * Using add() method from BaseDao
   */
  Flight::route('POST /advertisement/create', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::advertisementservice()->create_ad($data));
  });
