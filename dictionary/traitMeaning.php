<?php
namespace app\dictionary
{
  trait traitMeaning
  {
    private function requestMeaning($i,$q)
    {
      $en=self::$langDefault;
      if($math=self::requestMathematic($q)):
        return array('mathematic',$q,$math);
      elseif(self::requestChecker($i,$q,0,0,$en)):
        return array('meaning',$q,self::requestMyanmar($i,$q));
      elseif($numb=self::isNumeric($q)):
        return array('numeric',$numb,self::requestNumeric($numb));
      elseif($roma=self::requestRoman($q)):
        return array('roman',$q,$roma);
      elseif($deri=self::requestDerive($q) and isset($deri[1]) and $q!=$deri[1] and self::requestChecker($i,$deri[1],NULL,0,$en)):
        return array('derive',$q,self::requestMyanmar($i,$deri[1],$deri));
      elseif($deri and count($deri) > 1):
        // $tempOne = 'We currently have no definition of <b>%s</b>, please feel free to post and distribute...';
        // $tempTwo = 'click here to post %s definition!';
        // return array('derive',$q,
        //   array('Derived forms'=>$deri[0],
        //     "Oop..."=>array(
        //       array('not'=>sprintf($tempOne, $deri[1])),
        //       array('x add'=>sprintf($tempTwo, $deri[1]))
        //     )
        //   )
        // );
      // elseif($i < 999):
      // elseif(self::requestChecker(5,$q,'exam',3,$en)):
      //   return array('meaning',$q,self::requestMyanmar(5,$q));
      endif;
    }
    private function requestMeanings($query)
    {
      $r=array();
      self::$fileMobyThesaurus = false;
      self::$fileMobyPartsofspeech = false;
      self::$ruleAntonmy = false;
      self::$ruleDerivation = false;
      $resultFound = null;
      // foreach($query as $i => $q) if($m=self::requestMeaning($i,$q)) $r[$m[1]] = $m[2];
      foreach($query as $i => $q) {
        if($m=self::requestMeaning($i,$q)) {
          $r[$m[1]] = $m[2];
          $resultFound = 1;
        } else {
          $r[$q] = array(
            'Help'=>sprintf('todo: ...add <span class="word suggest zA" data-word="%1$s">%1$s</span> definition', $q)
          );
        }
      }
      // return $r;
      return $resultFound?$r:$resultFound;
      // if ($notfound===true) return $r;
    }
    private function requestMyanmar($i,$q,$derive=false)
    {
      $r = array();
      // $className = ($this->isAuthorization('detable') !== false)?' zA':NULL;
      foreach (self::$row[$i] as $rm) {
        $db = $this->myanmarQuery($rm['id']);
        foreach ($db->rows as $my) {
          $id=$my['id'];
          $grammar=self::$rowGrammar[$my['tid']];
          $r[$grammar][$id]['de'] = $my['define'];
          $describe = $my['describe'];
          if ($describe !='') $r[$grammar][$id]['eg'] = explode("\r\n",$describe);
        }
      }
      if (is_array($derive)) {
        $r['Derived forms']=$derive[0];
      } elseif ($derive=self::requestDerive($q)) {
        $r['Derived forms']=$derive[0];
      }
      if ($An=self::requestAntonym($i,$q)) $r['Antonym']=$An;
      if ($Mt=self::requestMobyThesaurus($q)) $r['Thesaurus']=$Mt;
      if ($Mb=self::requestMobyPartsOfSpeech($q)) $r['Parts of speech']=$Mb;


      $r['Suggestion']=sprintf('todo: ...suggest <span class="word suggest zA" data-word="%1$s">%1$s</span> to improve', $q);
      // $r['Total'] = self::$total[$i];
      return $r;
    }
    private function requestTranslate($i,$q)
    {
      if (self::requestChecker($i,$q)) {
        if (self::$total[$i] > 1) {
          /*
          $words ='';
          foreach (self::$row[$i] as $value) {
            $words .=$value[self::$columnEnglish].',';
            // self::rowDelete($value['id']);
          }
          // TODO: not sure? need to test
          $keywords = self::isUnique($words);
          // self::rowInsert($q,implode(',',$keywords));
          */
          $keywords = self::isUnique(implode(',',array_column(self::$row[$i],self::$columnEnglish)));
        } else {
          $keywords = self::isUnique(implode(',',array_column(self::$row[$i],self::$columnEnglish)));
        }
        if ($keywords and $d=self::requestMeanings($keywords)) return $d;
      } elseif ($d=self::requestMeaning(1,$q)){
        return array($d[1]=>$d[2]);
        // return $d;
      }
      // elseif(here google come):
    }
    private function requestTranslates($query)
    {
      foreach($query as $i => $q) if($m=self::requestTranslate($i,$q)) $r[$q]=$m;
      return $r;
    }
    private function requestTranslator($q)
    {
      // TODO: working...
      // $source=self::$langCurrent;
      // $target=self::$langDefault;
      // if(self::$ruleTranslateAPI == true) {
      //   $google = new \app\component\translator(self::$ruleTranslateAccess);
      //   if($google->requestTranslate($q,self::$langDefault,self::$langCurrent)) {
      //     $g = str_replace("% 20"," ",$google->text);
      //     if($q != $g) {
      //       self::rowAdd($q,$g);
      //       if($r=self::requestMeaning(1,$g)) return array($q => array($r[1]=>$r[2]));
      //     }
      //   }
      // }
    }
  }
}
