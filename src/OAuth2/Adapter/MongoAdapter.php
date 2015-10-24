<?php

namespace Strapieno\Auth\Api\OAuth2\Adapter;

use MongoDate;
use ZF\ApiProblem\Exception\DomainException;
use ZF\OAuth2\Adapter\MongoAdapter as ZfCampusMongoAdapter;

/**
 * Class MongoAdapter
 */
class MongoAdapter extends ZfCampusMongoAdapter
{
    // TODO rewiew to change config
    protected $identityField = 'user_name';

    protected $credentialField = 'password_crypt';

    /**
     * {@inheritdoc}
     */
    public function __construct($connection, $config = [])
    {
        $config = (array) $config;
        $config = array_merge([
            'client_table'          => 'oauth_client',
            'access_token_table'    => 'oauth_access_token',
            'refresh_token_table'   => 'oauth_refresh_token',
            'code_table'            => 'oauth_authorization_code',
            'user_table'            => 'user',
            'jwt_table'             => 'oauth_jwt',
        ], $config);


        parent::__construct($connection, $config);
    }

    /**
     * {@inheritdoc}
     */
    protected function resultExpireConverter($result)
    {
        if (is_array($result) && isset($result['expires']) && $result['expires'] instanceof \MongoDate) {
            $result['expires'] = $result['expires']->sec;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken($access_token)
    {
        $result = parent::getAccessToken($access_token);
        $result = $this->resultExpireConverter($result);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccessToken($access_token, $client_id, $user_id, $expires, $scope = null)
    {
        if (is_int($expires)) {
            $expires = new MongoDate($expires);
        }
        return parent::setAccessToken($access_token, $client_id, $user_id, $expires, $scope);
    }

    /**
     * {@inheritdoc}
     */
    public function getRefreshToken($refresh_token)
    {
        $result = parent::getRefreshToken($refresh_token);
        $result = $this->resultExpireConverter($result);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = null)
    {
        if (is_int($expires)) {
            $expires = new MongoDate($expires);
        }
        return parent::setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationCode($code)
    {
        $result = parent::getAuthorizationCode($code);
        $result = $this->resultExpireConverter($result);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthorizationCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope = null, $id_token = null)
    {
        if (is_int($expires)) {
            $expires = new MongoDate($expires);
        }
        return parent::setAuthorizationCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope, $id_token);
    }

    /**
     * @param $username
     * @return array|bool|null
     */
    public function getUser($username)
    {
        $cursor = $this->collection('user_table')->find([$this->identityField => $username]);

        if ($cursor->count() > 1) {
            $exception = new DomainException('Failure due to identity being ambiguous', 401);
            $exception->setType('http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html');
            $exception->setTitle('invalid_grant');
            throw $exception;
        }

        $result = null;
        foreach ($cursor as $result) {
            if ($result && isset($result['status'])) {
                if (!($result['status'] > 0)) {
                    $exception = new DomainException('User email has been not validated', 401);
                    $exception->setType('http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html');
                    $exception->setTitle('invalid_grant');
                    throw $exception;
                }
            }
        }

        return is_null($result) ? false : $result;
    }

    /**
     * @{@inheritdoc}
     */
    public function getUserDetails($username)
    {
        if ($user = $this->getUser($username)) {
            $user['user_id'] = $user[$this->identityField];
        }

        return $user;
    }

    /**
     * Check password using bcrypt
     *
     * @param string $user
     * @param string $password
     * @return bool
     */
    protected function checkPassword($user, $password)
    {
        return $this->verifyHash($password, $user[$this->credentialField]);
    }

    /**
     * Set the user
     *
     * @param string $username
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @return bool
     * @throws \RuntimeException
     */
    public function setUser($username, $password, $firstName = null, $lastName = null)
    {
        throw new \RuntimeException('Not allowed');
    }
}