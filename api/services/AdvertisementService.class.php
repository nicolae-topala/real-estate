<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/AdvertisementsDao.class.php";
require_once dirname(__FILE__)."/../dao/DescriptionsDao.class.php";

class AdvertisementService extends BaseService {

    private $descriptionDao;

    public function __construct() {
      $this->dao = new AdvertisementsDao();
      $this->descriptionDao = new DescriptionsDao();
    }

    public function get_users($search, $offset, $limit){
        if ($search){
          return $this->dao->get_users($search, $offset, $limit);
        }else{
          return $this->dao->get_all($offset, $limit);
        }
    }

    public function create_ad($data){

        if(!isset($data['admin_id'])) throw new Exception("Admin ID field is required.");
        if(!isset($data['title'])) throw new Exception("Title field is required.");
        if(!isset($data['location_id'])) throw new Exception("Location field is required.");
        if(!isset($data['type_id'])) throw new Exception("Type field is required.");
        if(!isset($data['price'])) throw new Exception("Price field is required.");
        if(!isset($data['address'])) throw new Exception("Address field is required.");

        try {
            $this->dao->beginTransaction();

            $description = $this->descriptionDao->add([
                "address" => $data['address'],
                "location_id" => $data['location_id'],
                "type_id" => $data['type_id'],
                "price" => $data['price'],
                "floor" => $data['floor'],
                "space" => $data['space'],
                "rooms" => $data['rooms'],
                "text" => $data['text']
            ]);

            $advertisement = parent::add([
                "admin_id" => $data['admin_id'],
                "title" => $data['title'],
                "description_id" => 1
            ]);

            $this->dao->commit();
        }catch(\Exception $e) {
            $this->dao->rollBack();
            throw $e;
        }
        parent::update($advertisement['id'], ["description_id" => $description['id']]);

        return $data;
    }
}
