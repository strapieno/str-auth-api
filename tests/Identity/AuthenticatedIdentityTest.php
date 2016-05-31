<?php

namespace Strapieno\Auth\Api\Identity;

use Zend\Permissions\Acl\Role\RoleInterface;
use Zend\Permissions\Rbac\AbstractRole as AbstractRbacRole;

/**
 * Class AuthenticatedIdentity
 */
class AuthenticatedIdentityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AuthenticatedIdentity
     */
    protected $identity;

    public function setUp()
    {
        $this->identity = new AuthenticatedIdentity('testIdentity');
    }

    public function testGetIdentity()
    {
        $this->assertSame('testIdentity', $this->identity->getAuthenticationIdentity());
    }

    /**
     * @depends testGetIdentity
     */
    public function testGetSetIdentityObject()
    {
        $identityObject = $this->getMockBuilder('Zend\Permissions\Acl\Role\RoleInterface')
            ->getMock();
        $this->identity->setAuthenticationObject($identityObject);
        $this->assertSame($identityObject, $this->identity->getAuthenticationObject());
    }

    /**
     * @depends testGetIdentity
     */
    public function testSetName()
    {
        $this->identity->setName('testName');
        $this->assertSame('testName', $this->identity->getName());
    }

    /**
     * @depends testGetSetIdentityObject
     */
    public function testGetRoleId()
    {
        $identityObject = $this->getMockBuilder('Zend\Permissions\Acl\Role\RoleInterface')
            ->setMethods(['getRoleId'])
            ->getMock();

        $identityObject->method('getRoleId')
            ->willReturn('test');

        $this->assertNull($this->identity->getRoleId());
        $this->identity->setAuthenticationObject($identityObject);
        $this->assertSame('test', $this->identity->getRoleId());
    }
}