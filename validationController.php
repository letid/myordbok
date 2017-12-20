<?php
namespace app
{
  class validationController extends \letId\request\validation
  {
    public function test()
    {
      echo 'app\validation('.$this->Id.')';
    }
  }
}