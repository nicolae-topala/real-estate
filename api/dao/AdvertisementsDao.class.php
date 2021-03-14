<?php

  require_once dirname(__FILE__)."/BaseDao.class.php";

  class AdvertisementsDao extends BaseDao{

    public function add_advertisement($advertisement){
      return $this->insert("advertisements", $advertisement);
    }

    public function update_advertisement($id, $advertisement){
      $this->update("advertisements", $id, $advertisement);
    }

  }
?>
