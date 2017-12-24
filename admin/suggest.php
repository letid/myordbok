<?php
namespace app\admin
{
  class suggest
  {
    private $suggestTable = 'en_suggest';
    public function __construct($dataPost)
    {
      $this->dataPost=$dataPost;
    }
    public function post()
    {
      // NOTE: userId, currentLanguage, wordId(source), ipAddress
      $db = avail::$database->insert($this->dataPost)->to($this->suggestTable)->execute()->rowsId();
      if ($db->rowsId) {
        return array('msg'=>'Thank you', 'status'=>'done');
      } elseif ($db->msg) {
        return array('msg'=>$db->msg, 'status'=>'fail');
      } else {
        return array('msg'=>'Error: please try again...', 'status'=>'fail');
      }
    }
    public function queries()
    {
    }
  }
}
