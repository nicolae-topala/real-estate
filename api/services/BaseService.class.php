<?php
class BaseService{
  protected $dao;

  public function get_by_id($id){
    return $this->dao->get_by_id($id);
  }

  public function add($data){
    return $this->dao->add($data);
  }

  public function update($id, $data){
    $result = $this->dao->update($id, $data);

    if(!$result) throw new Exception("Couldn't update the information, because the id ".$id." doesn't exist.", 404);
    return $this->dao->get_by_id($id);
  }
}
