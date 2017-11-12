<?php
namespace app\map
{
  use app;
  class definition extends mapController
  {
    public function __construct()
    {
      // app\avail::session()->delete();
      $this->timeCounter = app\avail::timer();
      app\avail::log()->counter();
    }
    public function classConcluded()
    {
      app\versoController::menu()->requestOne('page');
      app\versoController::menu()->requestOne('privacy');
      app\versoController::menu()->requestOne('user');
      app\versoController::menu()->requestOne('definition');
      app\versoController::menu()->requestOne('password');
      app\versoController::menu(array(
  			'menu'=>'ol', 'class'=>'MyOrdbok', 'attr'=>array( 'id'=>'MyOrdbok-logo', 'data-lang'=>app\avail::$config['lang'] ), 'list'=>'li', 'activeClass'=>'active', 'type'=>'dictionary'
  		))->requestOne('dictionary');
      app\verseController::menu()->request();
      $this->timerfinish = $this->timeCounter->finish();
    }
    public function home()
    {
      // $result = app\dictionary::search()->definition();
      $result = app\dictionary\request::search()->definition();
      // $r = app\dictionary\request::search();
      // $result = $r->definition();
      $page=$result['page'];
  		return $this->{"home_$page"}($result['result'],$result['language'],$page);
    }
    private function home_definition($d,$l,$p)
    {
      $definition = array();$row = array();
      /*
      foreach($d as $w => $v):
        if($k=key($v) and $w==$k):
          $definition['definition.word'][]=array('w'=>$w,'l'=>$l,'p'=>$p,'d'=>app\dictionary\request::requestHtmlEngine($v[$k]));
        else:
          foreach($v as $word => $trans)$row[] = array('w'=>$word,'l'=>'en','p'=>$p,'d'=>app\dictionary\request::requestHtmlEngine($trans));
          $definition['definition.sentence'][]=array('w'=>$w,'p'=>$p,'l'=>$l,'definition.word'=>$row);
        endif;
      endforeach;
      return array(
        'layout'=>array(
          'Title'=>'{q} define in Myanmar.',
          'Description'=>'the word {q} seem to be {lang.name}.',
          'Keywords'=>'{q}, {lang.name}, Myanmar dictionary, {q} means',
          'page.id'=>'definition',
          'page.class'=>'dictionary',
          'page.content'=>array(
            'layout.bar'=>array(),
            'layout.header'=>array(),
            'layout.board'=>array(),
            'definition'=>$definition,
            'layout.footer'=>array()
          )
        )
      );
      */
      // $this->responseType = 'text';
      foreach($d as $w => $v):
        if($k=key($v) and $w==$k):
          $definition['definition.word'][]=array('w'=>$w,'l'=>$l,'p'=>$p,'d'=>app\dictionary\request::html($v[$k]));
        else:
          foreach($v as $word => $trans)$row[] = array('w'=>$word,'l'=>'en','p'=>$p,'d'=>app\dictionary\request::html($trans));
          $definition['definition.sentence'][]=array('w'=>$w,'p'=>$p,'l'=>$l,'definition.word'=>$row);
        endif;
      endforeach;
      // return $definition;
      return array(
        'layout'=>array(
          'Title'=>'{q} define in Myanmar.',
          'Description'=>'the word {q} seem to be {lang.name}.',
          'Keywords'=>'{q}, {lang.name}, Myanmar dictionary, {q} means',
          'page.id'=>'definition',
          'page.class'=>'dictionary',
          'page.content'=>array(
            'layout.bar'=>array(),
            'layout.header'=>array(),
            'layout.board'=>array(),
            'definition'=>$definition,
            'layout.footer'=>array()
          )
        )
      );
    }
    private function home_notfound($d,$lang,$page)
    {
      return array(
        'layout'=>array(
          'Title'=>'{q} suggestion us',
          // 'Title'=>'We could not find your definition request',
          'Description'=>'Please make sure that you are defining {q}...',
          'Keywords'=>'{lang.name}, Myanmar, {q}, dictionary',
          'page.id'=>'definition',
          'page.class'=>'notfound',
          'page.content'=>array(
            'layout.bar'=>array(),
            'layout.header'=>array(),
            'layout.board'=>array(),
            'definition.notfound'=>array(),
            'layout.footer'=>array()
          )
        )
      );
    }
    private function home_pleaseenter($d,$lang,$page)
    {
      return array(
        'layout'=>array(
          'Title'=>'{name}',
          'Description'=>'...just type the word, and we will do the rest!',
          'Keywords'=>'{lang.name}, Myanmar dictionary, {name}',
          'page.id'=>'definition',
          'page.class'=>'pleaseenter',
          'page.content'=>array(
            'layout.bar'=>array(),
            'layout.header'=>array(),
            'layout.board'=>array(),
            'definition.pleaseenter'=>array(),
            'layout.footer'=>array()
          )
        )
      );
    }
  }
}
