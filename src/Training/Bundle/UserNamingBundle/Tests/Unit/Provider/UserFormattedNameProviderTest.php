<?php

namespace Training\Bundle\UserNamingBundle\Tests\Unit\Provider;

use PHPUnit\Framework\TestCase;
use Training\Bundle\UserNamingBundle\Provider\UserFormattedNameProvider;
use Oro\Bundle\UserBundle\Entity\User;

class UserFormattedNameProviderTest extends TestCase
{
    private $user;
    private $provider;

    protected function setUp(): void
    {
        $this->user = $this->createMock(User::class);
        $this->provider = new UserFormattedNameProvider();
    }

    /**
     * @dataProvider formatDataProvider
     */
    public function testGetFormattedName($format, $expected)
    {
        $this->user->method('getNamePrefix')->willReturn('Mr.');
        $this->user->method('getFirstName')->willReturn('John');
        $this->user->method('getMiddleName')->willReturn('David');
        $this->user->method('getLastName')->willReturn('Doe');
        $this->user->method('getNameSuffix')->willReturn('Jr.');

        $result = $this->provider->getFormattedName($this->user, $format);

        $this->assertEquals($expected, $result);
    }

    public function formatDataProvider(): array
    {
        return [
            ['PREFIX FIRST MIDDLE LAST SUFFIX', 'Mr. John David Doe Jr.'],
            ['PREFIX FIRST LAST', 'Mr. John Doe'],
            ['FIRST LAST', 'John Doe'],
            ['', ''],
            ['UNKNOWN FIRST UNKNOWN LAST UNKNOWN', 'UNKNOWN John UNKNOWN Doe UNKNOWN'],
            ['No name parts here', 'No name parts here'],
        ];
    }
}
