<?php

require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/AdvertisementService.class.php";
require_once dirname(__FILE__)."/../dao/DescriptionsDao.class.php";
require_once dirname(__FILE__)."/../dao/PhotosDao.class.php";
require_once dirname(__FILE__)."/../clients/CDNClient.class.php";

class PhotoService extends BaseService{

    private $CDNClient;

    public function __construct(){
        $this->dao = new PhotosDao();
        $this->DescriptionsDao = new DescriptionsDao();
        $this->AdvertisementService = new AdvertisementService();
        $this->CDNClient = new CDNClient();
    }

    public function upload($id, $data, $type){
        $verify = $this->AdvertisementService->get_ad_by_id($data['id']);

        if($verify['admin_id'] != $id)
            throw new Exception("You don't have access to this ad.", 500);

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $name = substr(str_shuffle($permitted_chars), 0, 16).'.png';

        try{
            $result = $this->dao->add([
                'description_id' => $verify['description_id'],
                'name' => $name
            ]);
        } catch(\Exception $e) {
            throw new Exception("Something went wrong with images upload.", 500, $e);
        }

        if($type == "thumbnail"){
          $this->DescriptionsDao->update($verify['description_id'], [
              'thumbnail_id' => $result['id']
          ]);
        }

        return $this->CDNClient->upload($name, $data['content']);
    }

    public function get_ad_photos($id){
        $id = $this->AdvertisementService->get_ad_by_id($id)['description_id'];

        return $this->dao->get_ad_photos($id);
    }
}
