<?php
namespace app\map;
use app;
class grammar extends mapController
{
  static private $location = '/grammar/grammar.json';
  private $hN = 1;
  public function __construct()
  {
    $this->timeCounter = app\avail::timer();
    // app\avail::log('visits')->counter();
    app\avail::log()->counter();
    // $this->storage_grammar = app\avail::$config['storage.root'].self::$location;
    $this->storage_grammar = 'D:\Server\lethil\app\myordbok\resource'.self::$location;
    // $this->page_current = app\avail::$http.'/'.app\avail::$uri[0];
    $this->page_current = '/'.app\avail::$uri[0].'/';
  }
  public function classConcluded()
  {
    app\versoController::menu()->requestOne('page');
    app\versoController::menu()->requestOne('privacy');
    app\versoController::menu()->requestOne('user');
    app\verseController::menu()->request();
    $this->timerfinish = $this->timeCounter->finish();
  }
  public function home()
  {
    $json = self::jsonRead($this->storage_grammar);
    $posCurrent = self::posRequest($json);
    if ($posCurrent) {
      $this->posResponse($json,$posCurrent);
    } else {
      $this->homeResponse($json);
    }
    return array(
      'layout'=>array(
        'page.id'=>'grammar',
        'page.class'=>'grammar',
        'page.content'=>array(
          'layout.bar'=>array(),
          'grammar'=>array(),
          'layout.footer'=>array()
        )
      )
    );
  }
  private function homeResponse($json)
  {
    $jsonContext = $json['context'];
    $jsonPos = $json['pos'];
    $jsonGrammar = $json['grammar'];
    $headerContext=array(
      'ul'=>array(
        'text'=>array_map(function($j) {
          return array(
            'li'=>array(
              'text'=>array(
                'strong'=>$j['name'],
                $j['desc']
              )
            )
          );
        }, $jsonContext['kind']),
        'attr'=>array(
          'class'=>'note'
        )
      )
    );
    $posContextKeys=array_keys($jsonPos);
    $posContext=array(
      'ul'=>array(
        'text'=>array_map(function($j,$k) {
          return array(
            'li'=>array(
              'text'=>array(
                'a'=>array(
                  'text'=>$j['root']['name'],
                  'attr'=>array(
                    'href'=>$this->page_current.'pos-'.$k
                  )
                ),
                'p'=>array(
                  'text'=>$j['root']['desc']
                )
              )
            )
          );
        }, $jsonPos,$posContextKeys),
        'attr'=>array(
          'class'=>'partsofspeech'
        )
      )
    );
    $grammarContext=array(
      'ul'=>array(
        'text'=>array_map(function($j,$k) {
          return array(
            'li'=>array(
              'text'=>array(
                'strong'=>array(
                  'text'=>$j['name']
                ),
                'p'=>array(
                  'text'=>$j['desc']
                )
              )
            )
          );
        }, $jsonGrammar,array_keys($jsonGrammar)),
        'attr'=>array(
          'class'=>'summary'
        )
      )
    );
    $this->Title = $jsonContext['name'];
    $this->Description = $jsonContext['desc'];
    $this->Keywords = implode(',',$posContextKeys);
    $this->headerContext = app\avail::html($headerContext);
    $this->secondaryContext = app\avail::html(
      array(
        array(
          'div'=>array(
            'text'=>$posContext,
            'attr'=>array(
              'class'=>'pos'
            )
          )
        ),
        array(
          'div'=>array(
            'text'=>$grammarContext,
            'attr'=>array(
              'class'=>'grammar'
            )
          )
        )
      )
    );
  }
  private function rootPos($json)
  {
    if (isset($json['note']) && $json['note']) {
      $headerContext=array(
        'ul'=>array(
          'text'=>array(
            'li'=>array(
              'text'=>$this->posExpression($json['note'])
            )
          ),
          'attr'=>array(
            'class'=>'note'
          )
        )
      );
      $this->headerContext = app\avail::html($headerContext);
    }
  }
  private function rootEngine($json)
  {
    $r=array();
    if (isset($json['desc'])) {
      array_push($r,array(
        'p'=>array(
          'text'=>$this->posExpression($json['desc'])
        )
      ));
    }
    if (isset($json['note']) && $json['note']) {
      array_push($r,array(
        'p'=>array(
          'text'=>$this->posExpression($json['note'])
        )
      ));
    }
    return $r;
  }
  private function kindPos($json)
  {
    return $this->kindEngine($json,1);
  }
  private function kindEngine($json,$h)
  {
    return array_map(function($j) use ($h) {
      $h = ($h <= 6)?$h+1:6;
      $heading = 'h'.$h;
      return array(
        'div'=>array(
          'text'=>array(
            $heading=>array(
              'text'=>$j['root']['name']
            ), $this->posKind($j,$h)
          )
        )
      );
    }, $json);
  }
  private function wordPos($json)
  {
    return $this->wordEngine($json);
  }
  private function wordEngine($json)
  {
    return array(
      'ul'=>array(
        'text'=>array_map(function($j){
          return array(
            'li'=>array(
              'text'=>$j
            )
          );
        }, $json['desc']),
        'attr'=>array(
          'class'=>'word',
          'data-name'=>$json['name']
        )
      )
    );
  }
  private function examPos($json)
  {
    return $this->examEngine($json);
  }
  private function examEngine($json)
  {
    return array(
      'ol'=>array(
        'text'=>array_map(function($j){
          return array(
            'li'=>array(
              'text'=>array(
                'p'=>array(
                  'text'=>$this->posExpression($j['name'])
                ),
                'ol'=>array(
                  'text'=>array_map(function($d){
                    return array(
                      'li'=>array(
                        'text'=>$this->posExpression($d)
                      )
                    );
                    }, $j['desc'])
                )
              )
            )
          );
        }, $json),
        'attr'=>array(
          'class'=>'exam'
        )
      )
    );

  }
  private function posExpression($d)
  {
    return preg_replace_callback('/[\'](.*?)[\']/', function ($k){
      return '<em>'.$k[1].'</em>';
    }, $d);
    // return $d;
  }
  private function posResponse($json,$posCurrent)
  {
    $jsonPos = $json['pos'];
    $jsonPosCurrent = $jsonPos[$posCurrent];
    $this->Title = $jsonPosCurrent['root']['name'];
    $this->Description = $jsonPosCurrent['root']['desc'];
    $this->Keywords = implode(',',$jsonPosCurrent['word']['desc']);
    $text=array_map(function($j,$i){
      if (is_callable(array($this,$i.'Pos'), false, $method)) {
        return call_user_func_array($method, array($j));
      }
    }, $jsonPosCurrent,array_keys($jsonPosCurrent));
    $this->secondaryContext = app\avail::html(
      array(
        'div'=>array(
          'text'=>$text,
          'attr'=>array(
            'class'=>array('detail',$posCurrent)
          )
        )
      )
    );
  }
  private function posKind($json,$h)
  {
    $text=array_map(function($j,$i) use($h) {
      if (is_callable(array($this,$i.'Engine'), false, $method)) {
        return call_user_func_array($method, array($j,$h));
      }
    }, $json,array_keys($json));
    if (!empty($text)) {
      return array(
        'div'=>array(
          'text'=>$text
        )
      );
    }
  }
  static private function posRequest($json)
  {
    if (isset(app\avail::$uri[1]) && strpos(app\avail::$uri[1],'-') == true) {
      $k = explode('-',app\avail::$uri[1]);
      if (count($k) == 2 && array_key_exists($k[0],$json)) {
        if (array_key_exists($k[1],$json[$k[0]])) return $k[1];
      }
    }
  }
  static private function jsonRead($file)
  {
    return json_decode(file_get_contents($file),true);
  }
}
