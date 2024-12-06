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
            fn($matches) => $replacements[$matches[0]] ?? $matches[0],
            $format
        );
    }
}
