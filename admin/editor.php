<?php
namespace app\admin
{
  class editor
  {
    public function __construct($dataPost=null)
    {
      $this->dataPost=$dataPost;
    }
    private function getById($Id)
    {
      return avail::$database->select()->from('en_src')->where('id',$Id)->execute();
    }
    public function get($Id)
    {
      $db = $this->getById($Id);
      return $db->fetchAssoc();
      // return call_user_func_array(array($this,$name),array());
    }
    public function post($name)
    {
      return call_user_func_array(array($this,$name),array());
    }
    private function postData()
    {
      // $column = array_intersect_key($_POST, array_flip(array('word','sense','exam','seq','tid')));
      $column = array_filter($_POST,function($v,$k){
        if (in_array($k,array('word','sense','exam','seq','tid'))){
          if($v) {
            return true;
          }
        }
      }, ARRAY_FILTER_USE_BOTH);
      $column = array_map(function($k,$v){
        // 'en_src.'.
        if (in_array($k,array('seq','tid'))){
          return array($k=>array($v));
        } else {
          return array($k=>$v);
        }
      },array_keys($column),$column);
      return array_reduce($column,'array_merge',array());
    }
    private function update()
    {
      $where = array_intersect_key($_POST, array_flip(array('id')));
      return avail::$database->update($this->postData())->to('en_src')->where($where)->execute()->rowsAffected();
    }
    private function insert()
    {
      return avail::$database->insert($this->postData())->to('en_src')->execute()->rowsAffected();
    }
    private function delete()
    {
      $where = array_intersect_key($_POST, array_flip(array('id')));
      return avail::$database->delete()->from('en_src')->where($where)->execute()->rowsAffected();
    }
  }
}
