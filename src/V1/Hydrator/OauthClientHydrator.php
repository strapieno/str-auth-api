<?php

namespace Strapieno\Auth\Api\V1\Hydrator;

use Matryoshka\Model\Hydrator\Strategy\DateTimeStrategy;

use Matryoshka\Model\Wrapper\Mongo\Hydrator\Strategy\MongoIdStrategy;
use Strapieno\Utils\Hydrator\DateHystoryHydrator;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;

/**
 * Class OauthClientHydrator
 */
class OauthClientHydrator extends DateHystoryHydrator
{
    public function __construct($underscoreSeparatedKeys = true)
    {
        parent::__construct($underscoreSeparatedKeys);
        $this->addStrategy('user_id', new MongoIdStrategy());
        // Filter
        $this->filterComposite->addFilter(
            'clientSecret',
            new MethodMatchFilter('getClientSecret', true),
            FilterComposite::CONDITION_AND
        );
        $this->filterComposite->addFilter(
            'roleId',
            new MethodMatchFilter('getRoleId', true),
            FilterComposite::CONDITION_AND
        );
        $this->filterComposite->addFilter(
            'password',
            new MethodMatchFilter('getPassword', true),
            FilterComposite::CONDITION_AND
        );
    }
}