<?php

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Entity\User;

class scbd extends AbstractProvider
{
    public $scopeSeparator = ' ';



    public $scopes = [

        'name',
        'account_id',
        'email',
    ];

    public $authorizationHeader = 'OAuth';

    /**
     * @var string If set, this will be sent to google as the "hd" parameter.
     * @link https://developers.google.com/accounts/docs/OAuth2Login#hd-param
     */
    public $hostedDomain = '';

    public function setHostedDomain($hd)
    {
        $this->hostedDomain = $hd;
    }

    public function getHostedDomain()
    {
        return $this->hostedDomain;
    }


    public function setAccessType($accessType)
    {
        $this->accessType = $accessType;
    }

    public function getAccessType()
    {
        return $this->accessType;
    }

    public function urlAuthorize()
    {
        return 'http://localhost:3000/oauth2/authorize';
    }

    public function urlAccessToken()
    {
        return 'http://192.168.1.122:8000/api/v2015/oauth2/token';
    }

    public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
    {

        return
            'http://192.168.1.122:8000/api/v2015/oauth2/token-info/'.$token;
    }

    public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        $response = (array) $response;

        $user = new User();

        $nameExploded = explode(' ',$response['name']);

        $email = $response['email'];
//print_r($response);die();

        $user->exchangeArray([
            'uid' => $response['user_id'],
            'name' => $response['name'],
            'firstname' => $nameExploded[0],
            'lastName' => $nameExploded[1],
            'email' => $response['email'],
        ]);

        return $user;
    }

    public function userUid($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        return $response['user_id'];
    }

    public function userEmail($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        return $response['email'];
    }

    public function userScreenName($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        return $response['name'];
    }

    public function getAuthorizationUrl($options = array())
    {
        $url = parent::getAuthorizationUrl($options);

        return $url;
    }
}
