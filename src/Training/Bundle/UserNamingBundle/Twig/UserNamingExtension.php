<?php

namespace Training\Bundle\UserNamingBundle\Twig;

use Oro\Bundle\UserBundle\Entity\User;

use Training\Bundle\UserNamingBundle\Provider\UserFormattedNameProvider;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class UserNamingExtension extends AbstractExtension
{
    /**
     * @param UserFormattedNameProvider $formattedNameProvider
     */
    public function __construct(private UserFormattedNameProvider $formattedNameProvider)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('formatted_name_example', [$this, 'getFormattedNameExample']),
            new TwigFunction('formatted_name', [$this, 'getRealFormattedName']),
        ];
    }

    /**
     * @param string $format
     * @return string
     */
    public function getFormattedNameExample(string $format): string
    {
        return $this->formattedNameProvider->getFormattedNameExample($format);
    }

    /**
     * @param string|null $format
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $middleName
     * @param string|null $namePrefix
     * @param string|null $nameSuffix
     * @return string
     */
    public function getRealFormattedName(
        string $format = null,
        string $firstName = null,
        string $middleName = null,
        string $lastName = null,
        string $namePrefix = null,
        string $nameSuffix = null
    ): string
    {
        $user = new User();
        $user->setNamePrefix($namePrefix)
            ->setFirstName($firstName)
            ->setMiddleName($middleName)
            ->setLastName($lastName)
            ->setNameSuffix($nameSuffix);

        return $this->formattedNameProvider->getFormattedName($user, $format);
    }
}
