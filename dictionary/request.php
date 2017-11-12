<?php
/**
* app\dictionary('love')->search('love')
* app\dictionary::search('love')->definition();
* app\dictionary::search('love')->suggestion();

* app\search::definition('love')->result();
* app\search::suggestion('love')->result();
* app\dictionary\request::suggestion('love')->result();
*/
namespace app\dictionary
{
  class request
  {
    use traitSetting, traitQuery, traitEngine, traitMeaning, traitWordweb, traitMathematic, traitMoby, traitUtility, traitHtml;
    public function __construct($q=null)
    {
      // $dictionaries = \app\avail::configuration()->dictionaries;
      // $VersoURI = \app\avail::$uri;
      self::$langCurrent = \app\avail::$config['lang']; //\app\avail::session('lang')->version()->get();
      if(isset($_GET['langCurrent'])) self::$langCurrent=$_GET['langCurrent'];
      if($q):
        $this->q = $q;
      elseif(isset($_GET['q'])):
        $this->q = $_GET['q'];
      elseif (isset(\app\avail::$uri[1])):
        if(\app\avail::$uri[0] == 'definition'):
          $this->q = \app\avail::$uri[1];
        elseif (isset(\app\avail::$uri[2])):
          $this->q = \app\avail::$uri[2];
        endif;
      endif;
    }
    static function search()
    {
      return new self();
    }
    /*
    self::search()->definition()
    */
    public function definition()
    {
      $q=$this->q;
      $r = array($q);
      // if($q && in_array(strtolower($q), self::$ruleRestrictedKeywords))
      $r = array('language'=>self::$langCurrent,'page'=>'definition','type'=>'none','result'=>array());
      if($q):
        $q = \app\avail::content('q')->set(trim(rawurldecode($q)));
        $r['query']=$q;
        if(self::$langCurrent == self::$langDefault):
          $r['kind']='definition';
          if($m=self::requestMeaning(999,$q)):
            $r['type']=$m[0];
            $r['result'][$q]=array($m[1]=>$m[2]);
          elseif($di=self::isSentence($q) and $d=self::requestMeanings($di)):
            $r['type']='sentence';
            $r['result'][$q]=$d;
          else:
            $r['page']='notfound';
          endif;
        else:
          $r['kind']='translation';
          if($d=self::requestTranslate(999,$q)):
            $r['type']='definition';
            $r['result']=array($q=>$d);
          elseif($d=self::isSentence($q)):
            $r['type']='sentence';
            $r['result']=self::requestTranslates($d);
          elseif($g=self::requestTranslator($q)):
            $r['type']='api';
            $r['result']=$g;
          else:
            $r['page']='notfound';
          endif;
        endif;
      else:
        $r['page']='pleaseenter';
      endif;
      return $r;
    }
    /*
    self::search()->suggestion()
    */
    public function suggestion()
    {
      if($this->q) return $this->suggestionQuery($this->q);
      return array();
    }
  }
}
