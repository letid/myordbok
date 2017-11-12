<?php
namespace app\dictionary
{
  trait traitWordweb
  {
    private function requestDerive($q)
    {
      if (is_array($q)) {
        return $q;
      } elseif (self::$ruleDerivation){
        $db = self::deriveQuery($q);
        if($db->result->num_rows){
          $r=array();
          foreach($db->rows as $w => $d) {
            if ($d['derive']==$q or $d['word']!=$q){
              // $r[$d['word']][]=$d['wame'];
              $r[$d['word']][]=array(
                $d['wame']=>$d['dame']
              );
            } else {
              // $r[$d['derive']][]=$d['dame'];
              $r[$d['derive']][]=array(
                $d['dame']=>$d['wame']
              );
            }
          }
          return array($r,$db->rows[0]['word']);
        }
      } else {
        return array(sprintf('todo: ...see Derive for %1$s', self::linkHtml(array($q))));
      }
    }
    private function requestAntonym($i,$q)
    {
      if (self::$ruleAntonmy) {
        $db=self::antonymQuery($q);
        if($db->result->num_rows){
          foreach($db->rows as $w => $d) $r[]=$d['word'];
          return $r;
        }
      } else {
        return sprintf('todo: ...see Antonym for %1$s', self::linkHtml(array($q)));
      }
    }
  }
}
