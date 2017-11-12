<?php
namespace app\dictionary
{
  trait traitQuery
  {
    private function requestChecker($i,$q,$r=NULL,$c=0,$l=NULL,$s='*')
    {
      // if(!$r)$r=self::$columnSource;
      if(!$r)$r='word';
      if(!$l)$l=self::$langCurrent;
      if($q=addslashes($q) and $c and $criteria=self::$ruleCriteria[$c]) $q=str_replace('q',$q,$criteria);
      $select = is_array($s)?implode(',',$s):$s;
      $db = \app\avail::$database->select($select)->from(self::tableName($l))->where($r,$q)->execute()->rowsCount()->toArray();
      self::$row[$i] = $db->rows;
      if ($db->rowsCount) {
        return self::$total[$i] = $db->rowsCount;
      }
      // if (isset($db->rowsCount)) {
      //   return self::$total[$i] = $db->rowsCount;
      // } else {
      //   print_r($db);
      // }
    }
    private function myanmarQuery($q)
    {
      // $g=addslashes($q);
      return \app\avail::$database->query(
        "SELECT d.*,s.`describe` FROM `en_define` d
          LEFT JOIN `en_describe` s ON s.`id` = d.`id`
        WHERE d.`wid` = '$q' ORDER BY d.`tid`, d.`sid` ASC"
      )->execute()->rowsCount()->toArray();
    }
    private function deriveQuery($q)
    {
      // $g=addslashes($q);
      return \app\avail::$database->query(
        "SELECT
          w.`word_id` AS id, w.`word` AS word, d.`word` AS derive, d.`derived_type` AS d_type, d.`word_type` AS w_type, wt.`name` AS wame, dt.`derivation` AS dame
        FROM `ww_derive` d
          INNER JOIN `ww_word` w ON w.`word_id`=d.`root_id`
          INNER JOIN `ww_derive_type` dt ON dt.`derived_type`=d.`derived_type`
          INNER JOIN `ww_word_type` wt ON wt.`word_type`=d.`word_type`
          WHERE (d.`word`='$q' OR w.`word`='$q') and (d.`derived_type` <> 0 OR d.`word_type` = 0);"
      )->execute()->rowsCount()->toArray();
    }
    private function antonymQuery($q)
    {
      return \app\avail::$database->query("SELECT w.`word` as word FROM `ww_antonym` AS a
			JOIN `ww_sense` s ON s.`word_sense`=a.`word_sense1`
			JOIN `ww_sense` w ON w.`word_sense`=a.`word_sense2`
				WHERE s.`word`='$q'
					GROUP BY w.`word`;")->execute()->toArray();
    }
    private function suggestionQuery($q)
    {
      return array_reduce(\app\avail::$database->select('word')->from(self::tableName(self::$langCurrent))->where('word',str_replace('q',$q,self::$ruleCriteria[1]))->limit(10)->execute()->group_by('word')->toJson()->rows, 'array_merge', array());
    }
    private function tableName($Id)
    {
      return $Id.'_word';
    }
  }
}
