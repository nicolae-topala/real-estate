<?php

require_once dirname(__FILE__)."/BaseDao.class.php";

class PhotosDao extends BaseDao{
    public function __construct(){
        parent::__construct("photos");
    }

    public function get_ad_photos($id){
        return $this->query("SELECT * FROM photos WHERE description_id = :id",
                            ["id" => $id]);
    }

    public function get_ad_thumbnail($id){
        return $this->query("SELECT * FROM descriptions WHERE thumbnail_id = :id",
                            ["id" => $id]);
    }

    public function remove($filename){
        return parent::remove($filename);
    }

    public function delete_photos($description_id){
        $this->query_unique("UPDATE descriptions
                             SET thumbnail_id = NULL
                             WHERE id = :description_id", ["description_id" => $description_id]);

         $this->query_unique("DELETE FROM photos
                              WHERE description_id = :description_id", ["description_id" => $description_id]);
    }
}
