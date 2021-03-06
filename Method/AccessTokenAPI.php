<?php

/**
 * This file is part of the StackExchangeApiClient library.
 *
 * @author  benatespina <benatespina@gmail.com>
 *
 * @license MIT
 */

namespace BenatEspina\StackExchangeApiClient\Method;

use BenatEspina\StackExchangeApiClient\Client;
use BenatEspina\StackExchangeApiClient\Model\AccessToken;

/**
 * Class AccessTokenAPI.
 *
 * @package BenatEspina\StackExchangeApiClient\Method
 */
class AccessTokenAPI
{
    /**
     * Client instance.
     *
     * @var \BenatEspina\StackExchangeApiClient\Client
     */
    protected $client;

    /**
     * The prefix of access tokens API requests.
     *
     * @var string
     */
    protected $prefix = '/access-tokens';

    /**
     * Constructor.
     *
     * @param \BenatEspina\StackExchangeApiClient\Client $client that will be used to connect the server
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Immediately expires the access tokens passed.
     *
     * More info: https://api.stackexchange.com/docs/invalidate-access-tokens
     *
     * @param string[] $accessTokens The array which contains the accessTokens delimited by semicolon
     * @param string[] $params       QueryString parameter(s), it admits page and pagesize; by default is null
     *
     * @return array<BenatEspina\StackExchangeApiClient\Model\AccessTokenInterface>
     */
    public function getInvalidateAccessTokens($accessTokens, $params = array())
    {
        return $this->responseToAccessToken(
            $this->client->get($this->prefix . '/' . implode(';', $accessTokens) . '/invalidate', $params)
        );
    }

    /**
     * Reads the properties for a set of access tokens.
     *
     * More info: https://api.stackexchange.com/docs/read-access-tokens
     *
     * @param string[] $accessTokens The array which contains the accessTokens delimited by semicolon
     * @param string[] $params       QueryString parameter(s), it admits page and pagesize; by default is null
     *
     * @return array<BenatEspina\StackExchangeApiClient\Model\AccessTokenInterface>
     */
    public function getAccessTokens($accessTokens, $params = array())
    {
        return $this->responseToAccessToken(
            $this->client->get($this->prefix . '/' . implode(';', $accessTokens), $params)
        );
    }

    /**
     * Allows an application to de-authorize itself for a set of users.
     *
     * More info: https://api.stackexchange.com/docs/application-de-authenticate
     *
     * @param string[] $accessTokens The array which contains the accessTokens delimited by semicolon
     * @param string[] $params       QueryString parameter(s), it admits page and pagesize; by default is null
     *
     * @return array<BenatEspina\StackExchangeApiClient\Model\AccessTokenInterface>
     */
    public function getDeAuthenticateAccessTokens($accessTokens, $params = array())
    {
        return $this->responseToAccessToken(
            $this->client->get($this->prefix . '/' . implode(';', $accessTokens) . '/de-authenticate', $params)
        );
    }

    /**
     * Transforms the json decodes array to accessToken objects array.
     *
     * @param mixed $response Decoded array containing response
     *
     * @return array<BenatEspina\StackExchangeApiClient\Model\AccessTokenInterface>
     */
    private function responseToAccessToken($response)
    {
        $accessTokens = array();
        foreach ($response['items'] as $response) {
            $accessTokens[] = new AccessToken($response);
        }

        return $accessTokens;
    }
}
