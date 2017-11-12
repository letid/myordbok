<?php
namespace app\editor
{
  use app\avail;
  class suggest
  {
    private $suggestTable = 'en_suggest';
    public function __construct($dataPost)
    {
      $this->dataPost=$dataPost;
    }
    static function request($dataPost)
    {
      return new self($dataPost);
    }
    /*
    obj = new suggest([]);
    return obj->post();
    return self::request([])->post();
    */
    public function post()
    {
      // NOTE: userId, currentLanguage, wordId(source), ipAddress
      // $db = \app\avail::$database->insert($dataForm)->to(self::$suggestTable)->build();
      $db = avail::$database->insert($this->dataPost)->to($this->suggestTable)->execute()->rowsId();
      if ($db->rowsId) {
        return array('msg'=>'Thank you', 'status'=>'done');
      } elseif ($db->msg) {
        return array('msg'=>$db->msg, 'status'=>'fail');
      } else {
        return array('msg'=>'Error: please try again...', 'status'=>'fail');
      }
    }
  }
}
