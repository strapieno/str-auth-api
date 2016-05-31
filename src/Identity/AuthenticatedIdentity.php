<?php

namespace Strapieno\Auth\Api\Identity;

use Zend\Permissions\Acl\Role\RoleInterface;
use Zend\Permissions\Rbac\AbstractRole as AbstractRbacRole;

/**
 * Class AuthenticatedIdentity
 */
class AuthenticatedIdentity extends AbstractRbacRole implements IdentityInterface
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
     * @return null|string
     */
    public function getRoleId()
    {
        $identityObject = $this->getAuthenticationObject();
        if ($identityObject) {
            return $identityObject->getRoleId();
        }
        return null;
    }

    /**
     * @return null|array
     */
    public function getAuthenticationIdentity()
    {
        return $this->identity;
    }

    /**
     * @param $name string
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return RoleInterface|null
     */
    public function getAuthenticationObject()
    {
        return $this->identityObject;
    }

    /**
     * @param RoleInterface $identityObject
     * @return $this
     */
    public function setAuthenticationObject(RoleInterface $identityObject)
    {
        if (!is_object($identityObject)) {
            // TODO Exception
        }
        $this->identityObject = $identityObject;
        return $this;
    }
}