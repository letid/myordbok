<?php
namespace app;
class authorizationController extends \letId\request\authorization
{
  protected $table = array(
    'user' => 'users'
  );
}