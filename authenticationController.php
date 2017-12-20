<?php
namespace app
{
  class authenticationController extends \letId\request\authentication
  {
    protected $table = array(
      'user' => 'users'
    );
    protected function client()
    {
      authGoogle::client()->user()->sign($this->table['user']);
    }
    public function clientGoogleAuth()
    {
      return true;
    }
    public function clientNotGoogleAuth()
    {
      return !authGoogle::client()->user()->accessToken();
    }
  }
}