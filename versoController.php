<?php
namespace app
{
  class versoController extends \letId\request\verso
  {
    protected $requestWrap = array(
      'user'=>array(
        'ul'=>array(
          'text'=>array(
            'li'=>array(
              'text'=>array(
                'div'=>array(
                  'text'=>array(
                    'span'=>array(
                      'text'=>'{user.displayname}',
                      'attr'=>array('style'=>'display:none')
                    )
                  ),
                  'attr'=>array('class'=>'toggle panel zA icon-user')
                ),
                '{menu.user}'
              ),
              'attr'=>array('class'=>'actives')
            )
          )
        )
      )
    );
    static function menu($Id=array())
    {
			return new self($Id);
    }
  }
}