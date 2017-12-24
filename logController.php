<?php
namespace app
{
  class logController extends \letId\request\log
  {
    protected $table = 'visits';
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
      $visits = avail::$database->select('locale, lang, view, modified, created')->from($this->table)->where($this->rowSelector)->execute()->rowsCount()->fetchAssoc();
      if ($visits->rowsCount) {
        avail::configuration($visits->rows)->merge();
      } else {
        avail::configuration(array('lang'=>'en','locale'=>'en'))->merge();
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
      $dictionaries = avail::configuration('dictionaries')->own();

      if ($VersoURI && $VersoURI[0] == 'dictionary' && count($VersoURI) > 1) {
        $lang=avail::arrays(end($VersoURI))->search_value($dictionaries)->get_key(0);
        if ($lang && avail::$config['lang'] != $lang) {
          $sessionDictionary->set($lang);
          avail::configuration('lang')->set($lang);
        }
      }
      $lN = array_column($dictionaries, avail::$config['lang']);
      // avail::content('lang.name')->set($lN[0]);
      avail::content('lang.name')->set(avail::language($lN[0])->get());
    }
  }
}