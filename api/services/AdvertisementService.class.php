<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/AdvertisementsDao.class.php";
require_once dirname(__FILE__)."/../dao/DescriptionsDao.class.php";
require_once dirname(__FILE__)."/../dao/PhotosDao.class.php";
require_once dirname(__FILE__)."/../clients/CDNClient.class.php";

class AdvertisementService extends BaseService {

    private $descriptionDao;
    private $photosDao;
    private $CDNClient;

    public function __construct() {
      $this->dao = new AdvertisementsDao();
      $this->descriptionDao = new DescriptionsDao();
      $this->photosDao = new PhotosDao();
      $this->CDNClient = new CDNClient();
    }

    public function get_user_advertisements($offset, $limit, $user_id, $order){
        if(!$user_id) throw new Exception("You need to insert user id.", 500);

        return $this->dao->get_user_advertisements($offset, $limit, $user_id, $order);
    }

    public function get_advertisements($title, $offset, $limit, $order, $floors_min, $floors_max, $price_min, $address,
                                       $price_max, $location_id, $type_id, $space_min, $space_max, $rooms_min, $rooms_max){
      $ad=[
          "title" => $title,
          "floors_min" => $floors_min,
          "floors_max" => $floors_max,
          "price_min" => $price_min,
          "price_max" => $price_max,
          "location_id" => $location_id,
          "type_id" => $type_id,
          "space_min" => $space_min,
          "space_max" => $space_max,
          "rooms_min" => $rooms_min,
          "rooms_max" => $rooms_max,
          "address" => $address
      ];
          return $this->dao->get_advertisements($offset, $limit, $ad, $order);
    }

    public function get_ad_by_id($id){
        $result = $this->dao->get_ad_by_id($id);
        if(!$result) throw new Exception("There is no AD with such ID !", 404);

        return $result;
    }

    public function create_ad($user, $data){
        if(!isset($data['title'])) throw new Exception("Title field is required.", 500);
        if(!isset($data['location_id'])) throw new Exception("Location field is required.", 500);
        if(!isset($data['type_id'])) throw new Exception("Type field is required.", 500);
        if(!isset($data['price'])) throw new Exception("Price field is required.", 500);
        if(!isset($data['address'])) throw new Exception("Address field is required.", 500);

        if(!isset($data['space']) || strlen($data['space'])<1) $data['space'] = 0;
        if(!isset($data['floor']) || strlen($data['floor'])<1) $data['floor'] = 0;
        if(!isset($data['rooms']) || strlen($data['rooms'])<1) $data['rooms'] = 0;
        if(!isset($data['text']) || strlen($data['text'])<1) $data['text'] = "";

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
                "admin_id" => $user['id'],
                "title" => $data['title'],
                "description_id" => 1
            ]);

            $this->dao->commit();
        }catch(\Exception $e) {
            $this->dao->rollBack();
            throw $e;
        }

        $this->dao->update($advertisement['id'], ["description_id" => $description['id']]);
        return $advertisement + $description;
    }

    public function modify_ad($id, $data, $user){
        if(!isset($data['title'])) throw new Exception("Title field is required.", 500);
        if(!isset($data['location_id'])) throw new Exception("Location field is required.", 500);
        if(!isset($data['type_id'])) throw new Exception("Type field is required.", 500);
        if(!isset($data['price'])) throw new Exception("Price field is required.", 500);
        if(!isset($data['address'])) throw new Exception("Address field is required.", 500);

        if(!isset($data['space']) || strlen($data['space'])<1) $data['space'] = 0;
        if(!isset($data['floor']) || strlen($data['floor'])<1) $data['floor'] = 0;
        if(!isset($data['rooms']) || strlen($data['rooms'])<1) $data['rooms'] = 0;
        if(!isset($data['text']) || strlen($data['text'])<1) $data['text'] = "";

        try {
            $this->dao->beginTransaction();

            $advertisement = parent::update($id, [
                "admin_id" => $user['id'],
                "title" => $data['title'],
            ]);

            $description = $this->descriptionDao->update($advertisement['description_id'], [
                "address" => $data['address'],
                "location_id" => $data['location_id'],
                "type_id" => $data['type_id'],
                "price" => $data['price'],
                "floor" => $data['floor'],
                "space" => $data['space'],
                "rooms" => $data['rooms'],
                "text" => $data['text']
            ]);

            $this->dao->commit();

        }catch(\Exception $e) {
            $this->dao->rollBack();
            throw $e;
        }

        return $advertisement + $description;
    }

    public function modify_user_ad($id, $data, $user){
        if( $this->verify_ad_user($user['id'], $id) == true ){
            return $this->modify_ad($id, $data, $user);
        } else {
            throw new Exception("You do not own this ad.", 500);
        }
    }

    public function verify_ad_user($id, $ad){
        $ad = $this->dao->get_ad_by_id($ad);

        if($id == $ad['admin_id']){
            return true;
        } else {
            throw new Exception("You do not own this ad.", 500);
        }
    }

    public function delete_ad($user, $ad){
        $ad = $this->dao->get_ad_by_id($ad);

        if( $this->verify_ad_user($user['id'], $ad['id']) == true ){
            $photos = $this->photosDao->get_ad_photos($ad['description_id']);
            foreach ($photos as $photo) {
                $this->CDNClient->delete($photo['name']);
            }

            $this->photosDao->delete_photos($ad['description_id']);
            $this->dao->delete_ad($ad['description_id']);
            $this->descriptionDao->delete_description($ad['description_id']);
        } else {
            throw new Exception("You do not own this ad.", 500);
        }

        return ["message" => "Ad succesfully deleted."];
    }
}
