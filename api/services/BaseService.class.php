<?php

class BaseService{
  protected $dao;

  public function get_by_id($id){
    return $this->dao->get_by_id($id);
  }

  public function add($data){
    return $this->dao->data($data);
  }

  public function update($id, $data){
    $this->dao->update($id, $data);

    return $this->dao->get_by_id($id);
  }
}
