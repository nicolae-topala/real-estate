<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/LocationsDao.class.php";

class LocationService extends BaseService {
    public function __construct() {
      $this->dao = new LocationsDao();
    }

    public function get_locations(){
          return $this->dao->get_locations();
    }
}
