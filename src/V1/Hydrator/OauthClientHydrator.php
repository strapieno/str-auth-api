<?php

namespace Strapieno\Auth\Api\V1\Hydrator;

use Matryoshka\Model\Hydrator\Strategy\DateTimeStrategy;
use Matryoshka\Model\Wrapper\Mongo\Hydrator\Strategy\MongoIdStrategy;
use Strapieno\ModelUtils\Hydrator\DateHystoryHydrator;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;

/**
 * Class OauthClientHydrator
 */
class OauthClientHydrator extends DateHystoryHydrator
{
    public function __construct($underscoreSeparatedKeys = true)
    {
        $this->addStrategy('user_id', new MongoIdStrategy());
    }
}