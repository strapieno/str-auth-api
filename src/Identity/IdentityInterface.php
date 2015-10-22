<?php

namespace Strapieno\Auth\Api\Identity;

use ZF\MvcAuth\Identity\IdentityInterface as ZfCampusIdentityInterface;

/**
 * Interface IdentityInterface
 */
interface IdentityInterface extends ZfCampusIdentityInterface
{
    /**
     * @return Object|null
     */
    public function getAuthenticationObject();
}