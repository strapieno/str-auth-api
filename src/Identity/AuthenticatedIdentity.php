<?php

namespace Strapieno\Auth\Api\Identity;

/**
 * Class AuthenticatedIdentity
 */
class AuthenticatedIdentity implements IdentityInterface
{
    /**
     * @var string|null
     */
    protected $identity;

    /**
     * @var Object|null
     */
    protected $identityObject;

    /**
     * @param $identity
     */
    public function __construct($identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return strig
     */
    public function getRoleId()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getAuthenticationIdentity()
    {
        return $this->identity;
    }

    /**
     * @param $name strig
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Object|null
     */
    public function getAuthenticationObject()
    {
        return $this->identityObject;
    }

    /**
     * @return Object|null
     */
    public function setAuthenticationObject($identityObject)
    {
        if (!is_object($identityObject)) {
            // TODO Exception
        }
        $this->identityObject = $identityObject;
        return $this;
    }
}