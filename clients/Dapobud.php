<?php
namespace app\clients;

use yii\authclient\OAuth2;

class Dapobud extends OAuth2
{

    protected function defaultName()
    {
    	return 'dapobud';
    }

    protected function defaultTitle()
    {
    	return 'Dapobud';
    }

	protected function initUserAttributes()
	{
		return $this->api('user', 'GET');
	}

    public function buildAuthUrl(array $params = [])
    {
        // cuma mau ilangin xoauth_displayname
        $defaultParams = [
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'redirect_uri' => $this->getReturnUrl(),
        ];
        if (!empty($this->scope)) {
            $defaultParams['scope'] = $this->scope;
        }
        if ($this->validateAuthState) {
            $authState = $this->generateAuthState();
            $this->setState('authState', $authState);
            $defaultParams['state'] = $authState;
        }
        return $this->composeUrl($this->authUrl, array_merge($defaultParams, $params));
    }

    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $request->addHeaders(['Authorization' => sprintf("Bearer %s", $accessToken->getToken())]);
    }

    public function getEmail()
    {
    	return isset($this->getUserAttributes()['email'])
    		? $this->getUserAttributes()['email']
    		: null;
    }

    public function getUsername()
    {
    	return isset($this->getUserAttributes()['username'])
    		? $this->getUserAttributes()['username']
    		: null;
    }
}
