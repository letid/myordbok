<?php
namespace app\map;
use app;
class api extends mapController
{
  public $responseType = 'json';
  public function __construct()
  {
    app\avail::log()->counter();
  }
  /*
  api
  */
  public function home()
  {
    return array(
      app\avail::$config['name']=>app\avail::$config['version']
    );
  }
  /*
  api/nume
  */
  public function nume()
  {
    $q = isset($_GET['q'])?str_replace('.','',$_GET['q']):0;
    $o = new app\component\nume($q);
    return $o->request();
  }
  /*
  api/nune
  */
  public function nune()
  {
    $q = isset($_GET['q'])?str_replace('.','',$_GET['q']):0;
    $o = new app\component\nune($q);
    return $o->request();
  }
  /*
  api/thesaurus
  */
  public function thesaurus()
  {

  }
  /*
  api/dictionary
  */
  public function dictionary()
  {
    return app\avail::configuration()->dictionaries;
  }
  /*
  api/definition?q=love
  api/definition/love
  */
  public function definition()
  {
    return app\dictionary\request::search()->definition();
  }
  /*
  api/suggestion?q=love
  api/suggestion/love
  */
  public function suggestion()
  {
    return app\dictionary\request::search()->suggestion();
  }
  /*
  api/speech?q=love&l=en
  https://translate.google.com/translate_tts?ie=UTF-8&q=test&tl=zh-TW&client=tw-ob
  http://translate.google.com/translate_tts?tl={$l}&q={$q}
  */
  public function speech()
  {
    if (isset($_GET['q'])) {
      $q = urlencode($_GET['q']);
      if (isset($_GET['l'])) {
        $l = $_GET['l'];
        // $this->responseType='audio';
        $this->responseType=array(
          // 'Content-Type:text/plain'
          // 'Content-Type:application/json',
          'Accept-Ranges:bytes',
          'Content-type:audio/mpeg',
          'Content-Transfer-Encoding: binary',
          'letId: 1.5.8',
          'Pragma:cache'
        );
        // header("Accept-Ranges:bytes");
        // header("Content-type:audio/mpeg");
        // header("Content-Transfer-Encoding: binary");
        // header("Pragma:cache");
        return file_get_contents(sprintf('https://translate.google.com/translate_tts?ie=UTF-8&q=%s&tl=%s&client=tw-ob', $q, $l));
        // return 'Ok';
      }
    }
    return $_GET;
  }
  /*
  api/translate?q=love&l=en
  */
  public function translate()
  {
    // AIzaSyCXDAPSNcVG40pN7VfCjEW-r93VWbfnSHA, AIzaSyAQVd0rJkOQAwtgXlKc6SMJqFC2IZFGaVg
    if (isset($_GET['q'])) {
      $q = urlencode($_GET['q']);
      if (isset($_GET['l'])) {
        $l = $_GET['l'];
        $this->responseType='text';
        $o = new app\component\translator('AIzaSyAQVd0rJkOQAwtgXlKc6SMJqFC2IZFGaVg');
        return $o->request($q,$l);
      }
    }
    return $_GET;
  }
  /*
  api/post
  */
  public function post()
  {
    return app\editor\suggest::request(array_filter($_POST))->post();
  }
}
