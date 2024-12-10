<?php

namespace Training\Bundle\UserNamingBundle\Provider;

use Oro\Bundle\UserBundle\Entity\User;

class UserFormattedNameProvider
{
    public function getFormattedName(User $user, string $format): string
    {
        $replacements = [
            'PREFIX' => $user->getNamePrefix(),
            'FIRST' => $user->getFirstName(),
            'MIDDLE' => $user->getMiddleName(),
            'LAST' => $user->getLastName(),
            'SUFFIX' => $user->getNameSuffix(),
        ];

        return preg_replace_callback(
            '/\b(PREFIX|FIRST|MIDDLE|LAST|SUFFIX)\b/',
            function ($matches) use ($replacements) {
                $placeholder = $matches[0];
                return $replacements[$placeholder] ?? '';
            },
            $format
        );
    }

    public function getFormattedNameExample(string $format): string
    {
        $user = new User();
        $user->setNamePrefix('Mr.')
            ->setFirstName('John')
            ->setMiddleName('M')
            ->setLastName('Doe')
            ->setNameSuffix('Jr.');

        return $this->getFormattedName($user, $format);
    }
}
