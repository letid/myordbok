<?php
namespace app
{
	class authGoogle extends \letId\service\google
	{
		static function client()
		{
      return new self;
		}
		public function user()
		{
			if (self::connectClient()) {
				self::$client->setAuthConfig(avail::$config['storage.root'].'/client_secret.json');
				// self::$client->setAccessType("offline");
				self::$client->setIncludeGrantedScopes(true);
				self::$client->setRedirectUri('http://localhost/google/?oauth2callback');
				// self::$client->setScopes('email');
				self::$client->setScopes(
					array(
						"https://www.googleapis.com/auth/plus.login",
						"https://www.googleapis.com/auth/plus.me",
						"https://www.googleapis.com/auth/userinfo.email",
						"https://www.googleapis.com/auth/userinfo.profile"
					)
				);
			}
			return  $this;
		}
		public function sign($table)
		{
			$this->accessRemove(isset($_GET['signout']));
			if ($this->accessObserve()) {
				if (!avail::$authentication->usersCookie()->has()) {
					$authData = avail::arrays($this->authData)->key_rename(
						array('name'=>'displayname','given_name'=>'firstname','family_name'=>'lastname','email_verified'=>'status')
					);
					$column = array_intersect_key($authData, array_flip(array('email','displayname','status')));
					$db = avail::$database->insert($column)->to($table)->duplicateUpdate(array('logs'=>array('(logs+1)')))->execute()->rowsAffected();
					if ($db->rowsId) {
						avail::$authentication->usersCookie()->set(array('userid'=>$db->rowsId));
						if (isset($_GET['code'])) header("Location: /");
					}
				}
			} else {
				avail::content('authGoogleUrl')->set(self::$client->createAuthUrl());
			}
		}
  }
}