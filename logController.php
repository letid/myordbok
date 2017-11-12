<?php
namespace app
{
  class logController extends \letId\request\log
  {
    protected $table = 'visits';
    // static function hits()
  	// {
  	// 	return new self();
  	// 	// return new self('visits');
  	// }
    public function counter()
  	{
      $this->requestDictionary();
  		$this->requestVisits();
  		// $this->requestVisitsUser();
  	}
    /**
    * @param select(locale, lang, hit, modified, created)
    */
    private function requestVisitsUser()
    {
      // echo $this->table;
      // print_r($this->rowSelector);
      $visits = avail::$database->select('locale, lang, view, modified, created')->from($this->table)->where($this->rowSelector)->execute()->rowsCount()->toArray();
      if ($visits->rowsCount) {
        avail::configuration($visits->rows[0])->merge();
      } else {
        // avail::configuration(array('lang'=>'en','locale'=>'en'))->merge();
      }
    }
    private function requestDictionary()
    {
      $sessionDictionary = avail::session('lang')->version();
      if ($sessionDictionary->has()) {
        avail::configuration('lang')->set($sessionDictionary->has());
      } else {
        $this->requestVisitsUser();
        $sessionDictionary->set(avail::$config['lang']);
      }
      // TODO: avail::$uri change to avail::$VersoURI
      $VersoURI = avail::$VersoURI;
      $dictionaries = avail::configuration()->dictionaries;



      if ($VersoURI && $VersoURI[0] == 'dictionary' && count($VersoURI) > 1) {
        $lang=avail::arrays(end($VersoURI))->search_value($dictionaries)->get_key(0);
        if ($lang && avail::$config['lang'] != $lang) {
          $sessionDictionary->set($lang);
          avail::configuration('lang')->set($lang);
        }
      }
      // $langName=avail::arrays(avail::$config['lang'])->search_key($dictionaries)->get_value(0);
      // avail::content('lang.name')->set($langName);

      $lN = array_column($dictionaries, avail::$config['lang']);
      avail::content('lang.name')->set($lN[0]);
    }
  }
}
