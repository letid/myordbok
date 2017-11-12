<?php
namespace app\dictionary
{
  trait traitEngine
  {
    private function isUnique($s,$e=',',$i=NULL,$r=NULL)
    {
      if(is_array($s)) $str = $s; else $str = explode($e,preg_replace('/\s+/',' ',$s));
      $str_unique = array_unique(array_filter($str));
      if ($i) {
        return ($r)? implode($r,$str_unique) : implode($str_unique);
      } else {
        return $str_unique;
      }
    }
    private function isSentence($q)
    {
      if($str = self::isUnique($q,' ') and count($str) > 1) return $str;
    }
    private function isNumeric($q)
    {
      if(is_numeric($q)) return number_format($q, 0, '', '');
        elseif(is_numeric(preg_replace("([^a-zA-Z0-9]|^\s)", '', $q)) and $f=(float)preg_replace('/[^0-9.]*/','',$q)) return number_format($f, 0, '', '');
    }
    private function rowAdd($q,$keywords)
    {
      // TODO: working...
      // if(self::$ruleTranslateInputData == true and self::$langCurrent != parent::$langDefault) {
      //   $this->table=self::tableName(self::$langCurrent);
      //   if(self::requestChecker(1001,$q)) {
      //     foreach (self::$row[1001] as $value) {
      //       $keywords .=','.$value[self::$columnEnglish]; self::rowDelete($value['id']);
      //     }
      //     $keywords = self::isUnique($keywords);
      //   }
      //   self::rowInsert($q,$keywords);
      // }
    }
    private function rowDelete($id)
    {
      // TODO: working...
      // \app\avail::$database->delete()->from($this->table)->where('id',$id)->execute();
    }
    private function rowInsert($q,$g)
    {
      // TODO: working...
      // app\avail::$database->insert(array(
      //     'source'=>addslashes($q), self::$columnEnglish=>addslashes($g)
      // ))->to($this->table)->execute();
    }
  }
}
