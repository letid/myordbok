<?php
namespace app
{
  class route
  {
    public $page = array(
      array(
        'Page'=>'',
        'Class'=>'home',
        'Method'=>'home',
        'Menu'=>'Home'
      ),
      array(
        'Page'=>'about',
        'Method'=>'about',
        'Menu'=>'About'
      ),
      array(
        'Class'=>'fonts',
        'Page'=>'myanmar-fonts',
        'Menu'=>'Fonts'
      ),
      array(
        'Class'=>'grammar',
        'Page'=>'grammar',
        'Menu'=>'Grammar'
      ),
      // array(
      //   'Class'=>'grammar',
      //   'Page'=>'googleAuthUrlss',
      //   'Menu'=>'Signin',
      //   'Link'=>'{googleAuthUrl}',
      //   // 'Link'=>array('googleAuthUrl','asdfasdf'),
      //   // 'Link'=>'http://apple/org',
      //   'Auth'=>array(
      //     'googleAuth'
      //   )
      // ),
      // NOTE: api
      array(
        'Page'=>'api',
        'Class'=>'api',
        'Menu'=>'API',
        'Type'=>'api',
        array(
          'Page'=>'dictionary',
          'Method'=>'dictionary'
        ),
        array(
          'Page'=>'nume',
          'Method'=>'nume'
        ),
        array(
          'Page'=>'nune',
          'Method'=>'nune'
        ),
        array(
          'Page'=>'suggestion',
          'Method'=>'suggestion'
        ),
        array(
          'Page'=>'definition',
          'Method'=>'definition',
          'Auth'=>'superAdmin'
        ),
        array(
          'Page'=>'speech',
          'Method'=>'speech'
        ),
        array(
          'Page'=>'translate',
          'Method'=>'translate'
        ),
        array(
          'Page'=>'post',
          'Method'=>'post'
        ),
        array(
          'Page'=>'import',
          'Method'=>'import',
          'Auth'=>'superAdmin'
        ),
        array(
          'Page'=>'editor',
          'Method'=>'editor',
          // 'Auth'=>'superAdmin'
        )
      ),
      // NOTE: dictionary
      array(
        'Page'=>'dictionary',
        'Method'=>'dictionary',
        'Menu'=>array('lang.name','Myanmar'),
        'Type'=>'dictionary'
      ),
      // NOTE: definition
      array(
        'Page'=>'definition',
        'Class'=>'definition',
        // 'Method'=>'home',
        'Menu'=>'Definition',
        'Type'=>'definition'
      ),
      // NOTE: privacy
      array(
        'Page'=>'privacy',
        'Method'=>'privacy',
        'Menu'=>'Privacy',
        'Type'=>'privacy'
      ),
      array(
        'Page'=>'terms',
        'Method'=>'terms',
        'Menu'=>'Terms',
        'Type'=>'privacy'
      ),
      // NOTE: user
      array(
        'Page'=>'signin',
        'Class'=>'sign',
        'Method'=>'signin',
        'Menu'=>'Signin',
        'Type'=>'user',
        'Auth'=>'guest'
      ),
      array(
        'Page'=>'signup',
        'Class'=>'sign',
        'Method'=>'signup',
        'Menu'=>'Signup',
        'Type'=>'user',
        'Auth'=>'guest'
      ),
      array(
        'Page'=>'forgot-password',
        'Class'=>'sign',
        'Method'=>'forgotPassword',
        'Menu'=>'Forgot password',
        'Type'=>'password',
        'Auth'=>'guest'
      ),
      array(
        'Page'=>'reset-password',
        'Class'=>'sign',
        'Method'=>'resetPassword',
        'Menu'=>'Reset password',
        'Type'=>'password',
        'Auth'=>'guest'
      ),
      // NOTE: auth
      array(
        'Page'=>'auth',
        'Class'=>'sign',
        // 'Method'=>'home',
        'Menu'=>'user.displayname',
        'Type'=>'user',
        'Auth'=>array(
          'user'
        ),
        array(
          'Page'=>'update',
          'Method'=>'update',
          'Menu'=>'Update'
        ),
        array(
          'Page'=>'update?cheml',
          'Method'=>'update',
          'Menu'=>'Change email',
          'Auth'=>'clientNotGoogleAuth'
        ),
        array(
          'Page'=>'update?chpwd',
          'Method'=>'update',
          'Menu'=>'Change password',
          'Auth'=>'clientNotGoogleAuth'
        ),
        array(
          'Page'=>'update?chdis',
          'Method'=>'update',
          'Menu'=>'Change displayname'
        ),
        array(
          'Page'=>'signout',
          'Menu'=>'Signout',
          'Method'=>'signout',
          'Link'=>'?signout'
        )
      )
    );
    public function __construct()
    {
      // avail::session()->delete();
      // $this->page['myordbokorgange'] = array(
      //       'Method'=>'aboutUs',
      //       'Menu'=>'MyOrdboks d',
      //       'burglish'=>array(
      //         'Method'=>'burglish',
      //         'Menu'=>'Burglish'
      //       )
      //     );
      // return $this->page;
    }
  }
}
