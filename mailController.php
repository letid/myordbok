<?php
namespace app
{
  class mailController extends \letId\request\mail
  {
    public function test()
    {
      echo 'app\mail('.$this->Id.')';
  	}
  }
}
