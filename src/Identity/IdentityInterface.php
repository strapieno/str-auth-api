<?php

namespace Strapieno\Auth\Api\Identity;

use Zend\Permissions\Acl\Role\RoleInterface;
use ZF\MvcAuth\Identity\IdentityInterface as ZfCampusIdentityInterface;

/**
 * Interface IdentityInterface
 */
interface IdentityInterface extends ZfCampusIdentityInterface
{
    /**
     * @return Object|null
     */
    public function setAuthenticationObject(RoleInterface $identityObject);

    /**
     * @return RoleInterface|null
     */
    public function getAuthenticationObject();
}