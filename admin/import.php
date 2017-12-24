<?php
namespace app\admin
{
  /*
  db_en_org
    db_en_org -> en_src_org
  db_en
    db_en -> en_src
      source -> word
      state -> tid
      def -> sense
      exam -> exam (??)
      status -> kid
      word_id -> wid

      pron -> (delete)
      type_id -> (delete it)
      definition_id -> (delete it)
      mdate -> delete
  en_word

  en_define
    en_define -> en_sense
      define -> sense
  en_describe
    en_describe -> en_exam
      describe -> exam
  */
  /*
  35.225.79.37
  lethil/remote2SQL
  */
  class import
  {
    public function __construct($dataPost=null)
    {
      // $this->dataPost=$dataPost;
    }
    private function deleteFrom($tableName)
    {
      // $db = avail::$database->truncate('TABLE')->from($tableName)->execute();
      return avail::$database->delete_from($tableName)->execute();
    }
    private function resetId()
    {
      return avail::$database->query(
        "ALTER TABLE `en_srcf` DROP COLUMN `id`; ALTER TABLE `en_srcf` ADD COLUMN `id` INT(10) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);"
      )->execute();
    }
    private function updateId()
    {
      // UPDATE `en_src` SET `wid` = 0;
      return avail::$database->query(
        'UPDATE `en_src` o INNER JOIN `en_src` s ON s.`word` = o.`word` SET o.`wid` = s.`id`;'
      )->execute();
    }
    private function word()
    {
      if ($this->deleteFrom('en_word')) {
        return avail::$database->query(
          "INSERT INTO `en_word` (`id`,`word`) SELECT `wid`,`word` FROM `en_src` WHERE `word` !='' GROUP BY `wid` ORDER BY `wid` ASC;"
          )->execute();
      }
    }
    private function sense()
    {
      if ($this->deleteFrom('en_sense')) {
        return avail::$database->query(
          "INSERT INTO `en_sense` (`id`,`sense`,`wid`,`tid`,`sid`,`kid`) SELECT o.`id`, o.`sense`, o.`wid`, o.`tid`, o.`seq`,  o.`kid` FROM `en_src` o WHERE o.`sense` IS NOT NULL;"
          )->execute();
      }
    }
    private function exam()
    {
      if ($this->deleteFrom('en_exam')) {
        return avail::$database->query(
          "INSERT INTO `en_exam` (`id`,`exam`) SELECT o.`id`, o.`exam` FROM `en_src` o WHERE o.`exam` IS NOT NULL;"
          )->execute();
      }
    }
    public function post($name)
    {
      return call_user_func_array(array($this,$name),array());
    }
  }
}
