<?php
namespace app
{
  class configurationController extends \letId\request\configuration
  {
    public $dictionaries = array(
      'International'=>array(
      	 'en'=>'English',
      	 'iw'=>'Hebrew',
      	 'el'=>'Greek',
      	 'pt'=>'Portuguese',
      	 'fr'=>'French',
      	 'nl'=>'Dutch',
      	 'ar'=>'Arabic',
      	 'es'=>'Spanish'
       ),
      'Europe'=>array(
      	 'no'=>'Norwegian',
      	 'fi'=>'Finnish',
      	 'ro'=>'Romanian',
      	 'pl'=>'Polish',
      	 'sv'=>'Swedish',
      	 'da'=>'Danish',
      	 'de'=>'German',
      	 'ru'=>'Russian'
       ),
      'Asia'=>array(
      	'ja'=>'Japanese',
      	'zh'=>'Chinese',
      	'ko'=>'Korean',
      	'ms'=>'Malay',
      	'tl'=>'Filipion',
      	'vi'=>'Vietnamese',
      	'th'=>'Thai',
      	'hi'=>'Hindi'
      )
    );
    /*
    $init['sol.default'] = 'en';
    $init['sol.url'] = 'dictionary/';
    foreach($init['sol.list'] as $k=>$v)foreach($v as $i=>$d)$database['mysql_table'][$i] = "db_$i";
    */
    /**
    * application's directory rewrite!
    */
    protected $rewrite = array(
      'src'=>'resource'
    );
    /**
    * application's directory
    */
    protected $directory = array(
      'template'=>'template',
      'language'=>'language'
    );
    /**
    * application's setting
    */
    protected $setting = array(
      // 'build' => '30.05.17.9.36',
    	// 'version' => '3.2.67',
    	// 'name' => 'MyOrdbok',
    	// 'copyright' => '2017',
    	// 'description' => 'online Myanmar dictionary',
      // NOTE: individual
      // 'visitsPrevious' => 27812305234506
      // 'locale' => 'en',
      // 'lang' => 'en',
    );
  }
}
