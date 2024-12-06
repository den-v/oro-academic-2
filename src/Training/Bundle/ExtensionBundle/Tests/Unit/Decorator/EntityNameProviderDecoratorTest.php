<?php

namespace Training\Bundle\ExtensionBundle\Tests\Unit\Decorator;

use PHPUnit\Framework\TestCase;
use Training\Bundle\ExtensionBundle\Decorator\EntityNameProviderDecorator;
use Oro\Bundle\EntityBundle\Provider\EntityNameProviderInterface;
use Oro\Bundle\UserBundle\Entity\User;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;
use Training\Bundle\UserNamingBundle\Provider\UserFormattedNameProvider;

class EntityNameProviderDecoratorTest extends TestCase
{
    private $originalProvider;
    private $formattedNameProvider;
    private $decorator;

    protected function setUp(): void
    {
        $this->originalProvider = $this->createMock(EntityNameProviderInterface::class);
        $this->formattedNameProvider = $this->createMock(UserFormattedNameProvider::class);
        $this->decorator = new EntityNameProviderDecorator(
            $this->originalProvider,
            $this->formattedNameProvider
        );
    }

    public function testGetNameWithUserEntityAndNamingType()
    {
        $user = $this->getMockBuilder(User::class)
            ->addMethods(['getNamingType'])
            ->getMock();
        $namingType = $this->createMock(UserNamingType::class);
        $namingType->method('getFormat')->willReturn('format_string');
        $user->expects($this->once())
            ->method('getNamingType')
            ->willReturn($namingType);

        $this->formattedNameProvider
            ->expects($this->once())
            ->method('getFormattedName')
            ->with($user, 'format_string')
            ->willReturn('John Doe');

        $result = $this->decorator->getName('format', 'en', $user);
        $this->assertEquals('John Doe', $result);
    }

    public function testGetNameWithUserEntityAndNoNamingType()
    {
        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('getNamingType')
            ->willReturn(null);

        $this->originalProvider
            ->expects($this->once())
            ->method('getName')
            ->with('format', 'en', $user)
            ->willReturn('Original Name');

        $result = $this->decorator->getName('format', 'en', $user);
        $this->assertEquals('Original Name', $result);
    }

    public function testGetNameWithNonUserEntity()
    {
        $entity = $this->createMock(\stdClass::class);

        $this->originalProvider
            ->expects($this->once())
            ->method('getName')
            ->with('format', 'en', $entity)
            ->willReturn('Non-user Name');

        $result = $this->decorator->getName('format', 'en', $entity);
        $this->assertEquals('Non-user Name', $result);
    }

    public function testGetNameDQL()
    {
        $this->originalProvider
            ->expects($this->once())
            ->method('getNameDQL')
            ->with('format', 'en', 'User', 'u')
            ->willReturn('SELECT ...');

        $result = $this->decorator->getNameDQL('format', 'en', 'User', 'u');
        $this->assertEquals('SELECT ...', $result);
    }
}
