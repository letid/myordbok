<?php
namespace app\map;
use app;
class home extends mapController
{
  public function __construct()
  {
    $this->timeCounter = app\avail::timer();
    // app\avail::log('visits')->counter();
    app\avail::log()->counter();
  }
  public function classConcluded()
  {
    app\verso::request('page')->menu();
    app\verso::request('privacy')->menu();
    app\verso::request('user')->menu();
    app\verso::request('definition')->menu();
    // app\verso::request('password')->menu();
    app\verso::request(array('attr'=>array('id'=>'MyOrdbok-logo','data-lang'=>app\avail::$config['lang']),'type'=>'dictionary'))->menu();
    app\verse::request()->menu();
    $this->timerfinish = $this->timeCounter->finish();
    // app\avail::assist()->error_get_last();
  }
  public function home()
  {
    // show the result!
    // print_r((string) $response->getBody());

    // $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
    // echo $f->format(1432);
    // print_r(app\avail::$user);
    // $date = new \DateTimeZone('Asia/Yangon');
    // $date = new \DateTime('NOW', new \DateTimeZone('Asia/Yangon'));
    // echo ltrim($date->format('m'), 0);
    // echo $date->format('n'); //Month
    // echo $date->format('j'); //Day
    // echo $date->format('W'); //Day
    // print_r($date);

    // date_default_timezone_set('Asia/Yangon');
    // $script_tz = date_default_timezone_get();
    // echo $script_tz;
    // echo ini_get('date.timezone');
    // $today = getdate();
    // print_r($today);
    // echo time();
    // if (strcmp($script_tz, ini_get('date.timezone'))){
    //     echo 'Script timezone differs from ini-set timezone.';
    // } else {
    //     echo 'Script timezone and ini-set timezone match.';
    // }
    // $date = new \DateTime('7:10pm', new \DateTimeZone('Europe/Paris'));
    // echo $date->format('Y-m-d H:i:sP');
    return array(
      'layout'=>array(
        'Title'=>'Myanmar dictionary',
        'Description'=>'online Myanmar dictionaries, available in 24 languages.',
        'Keywords'=>'Myanmar dictionary, Myanmar definition, Burmese, norsk ordbok, burmissk',
        'page.id'=>'home',
        'page.class'=>'home',
        'page.content'=>array(
          'layout.bar'=>array(),
          'home'=>array()
        )
      )
    );
  }
  public function about()
  {
    app\verso::request()->requestCount();
    app\verse::request()->requestCount();
    // app\verso::request('page')->menu();
    // app\menu::verse()->requestTotal();
    app\dictionary\request::requestTotal();
    return array(
      'layout'=>array(
        'Title'=>'About {name}, Free online Myanmar dictionaries',
        'Description'=>'{lang.name} - Myanmar dictionary.',
        'Keywords'=>'Myanmar dictionary, Burmesisk ordbok, Myanmar definition, Burmese, norsk ordbok, burmissk',
        'page.id'=>'about-us',
        'page.class'=>'about-us',
        'page.content'=>array(
          'layout.bar'=>array(),
          'aboutus'=>array(
            'dictionaries'=>app\avail::html(
              array(
                'ol'=>array(
                  'text'=>app\dictionary\request::requestMenu(),
                  'attr'=>array(
                    'class'=>array(
                      'dictionary'
                    )
                  )
                )
              )
            )
          ),
          'layout.footer'=>array()
        )
      )
    );
  }
  public function dictionary()
  {
    return array(
      'layout'=>array(
        'Title'=>'{lang.name} - Myanmar',
        'Description'=>'online {lang.name} to Myanmar dictionary',
        'Keywords'=>'{lang.name}, Myanmar, dictionary, definition',
        'page.id'=>'dd',
        'page.class'=>'dd',
        'page.content'=>array(
          'layout.bar'=>array(),
          'layout.header'=>array(),
          'layout.board'=>array(),
          'dictionary'=>array(
            'dictionaries'=>app\avail::html(
              array(
                'ol'=>array(
                  'text'=>app\dictionary\request::requestMenu(),
                  'attr'=>array(
                    'class'=>array(
                      'dictionary'
                    )
                  )
                )
              )
            )
          ),
          'layout.footer'=>array()
        )
      )
    );
  }
  public function terms()
  {
    return array(
      'layout'=>array(
        'Title'=>'Terms',
        'Description'=>'Terms of service, User license, Content, Proprietary Rights, Fees',
        'Keywords'=>'using the {name} service',
        'page.id'=>'terms',
        'page.class'=>'terms',
        'page.content'=>array(
          'layout.bar'=>array(),
          'terms'=>array(
            'Heading'=>'Terms of service'
          ),
          'layout.footer'=>array()
        )
      )
    );
  }
  public function privacy()
  {
    return array(
      'layout'=>array(
        'Title'=>'Privacy',
        'Description'=>'Your privacy is very important to us. Accordingly, we have developed this policy in order for you to understand how we collect, use, communicate and disclose and make use of personal information. The following outlines our privacy policy.',
        'Keywords'=>'privacy, policy',
        'page.id'=>'privacy',
        'page.class'=>'privacy',
        'page.content'=>array(
          'layout.bar'=>array(),
          'privacy'=>array(
            'Heading'=>'Privacy Policy'
          ),
          'layout.footer'=>array()
        )
      )
    );
  }
}
