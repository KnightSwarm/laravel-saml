<?php


use KnightSwarm\LaravelSaml\Account;


class SamlController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Saml Controller
	|--------------------------------------------------------------------------
	|
	| This Controller should handle users and auth through SAML
	|
	*/

    private $act;

    public function __construct(KnightSwarm\LaravelSaml\Account $act)
    {
        $this->account = $act;
    }

	public function login()
	{
        //$saml = new \KnightSwarm\LaravelSaml\Saml\SamlBoot();
        //$saml = $saml->getSimpleSaml();
        //$saml->getAttributes();

        if (!$this->account->samlLogged()) {
            Auth::logout();
            $this->account->samlLogin();
        }

        if ($this->account->samlLogged() && ! $this->account->laravelLogged()) {
            $uid = $this->account->getSamlUid();
            if ($this->account->userExists($uid)) {
                $this->account->laravelLogin($uid);
            } else {
                $this->account->createUser();
            }
        }



	}

    public function logout()
    {
        $this->account->logout();

    }

}