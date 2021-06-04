<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class DescriptionsDao extends BaseDao{
    public function __construct(){
        parent::__construct("descriptions");
    }

    public function delete_description($description_id){
        $this->query_unique("DELETE FROM descriptions
                             WHERE id = :description_id", ["description_id" => $description_id]);
    }
}
