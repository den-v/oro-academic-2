<?php

namespace Training\Bundle\ExtensionBundle\Tests\Unit\Decorator;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Bundle\EntityBundle\Provider\EntityNameProviderInterface;
use Training\Bundle\ExtensionBundle\Decorator\EntityNameProviderDecorator;

class EntityNameProviderDecoratorTest extends TestCase
{
    /** @var EntityNameProviderInterface|MockObject */
    private $originalProvider;

    /** @var EntityNameProviderDecorator */
    private $decorator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->originalProvider = $this->getMockForAbstractClass(EntityNameProviderInterface::class);
        $this->decorator = new EntityNameProviderDecorator($this->originalProvider);
    }

    /**
     * Data provider for the getName tests
     */
    public function nameProvider(): array
    {
        return [
            'to_be_decorated' => [
                $this->prepareUser('John', 'Doe', 'Middle'),
                'Doe John Middle'
            ],
            'not_to_be_decorated' => [
                new \stdClass(),
                'Entity Name'
            ],
        ];
    }

    private function prepareUser(string $firstName, string $lastName, string $middleName) : User
    {
        $user = new User();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setMiddleName($middleName);

        return $user;
    }

    /**
     * Test the getName method with multiple data sets
     *
     * @dataProvider nameProvider
     */
    public function testGetName($entity, $expected): void
    {
        if (!$entity instanceof User) {
            $this->originalProvider
                ->expects($this->once())
                ->method('getName')
                ->with($this->equalTo('full'), $this->equalTo('en'), $this->equalTo($entity))
                ->willReturn($expected);
        }

        $result = $this->decorator->getName('full', 'en', $entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * Test the getNameDQL method to ensure it delegates to the original provider
     */
    public function testGetNameDQL(): void
    {
        $format = 'full';
        $locale = 'en';
        $className = User::class;
        $alias = 'u';

        $this->originalProvider
            ->expects($this->once())
            ->method('getNameDQL')
            ->with($this->equalTo($format), $this->equalTo($locale), $this->equalTo($className), $this->equalTo($alias))
            ->willReturn('DQL Expression');

        $result = $this->decorator->getNameDQL($format, $locale, $className, $alias);

        $this->assertEquals('DQL Expression', $result);
    }
}
