<?php

namespace Training\Bundle\UserNamingBundle\Api\Processor\Get;

use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Training\Bundle\UserNamingBundle\Provider\UserFormattedNameProvider;

class NameExampleGetProcessor implements ProcessorInterface
{
    public function __construct(private UserFormattedNameProvider $formattedNameProvider)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContextInterface $context): void
    {
        $result = $context->getResult();
        if (
            is_array($result) &&
            array_key_exists('format', $result) &&
            !array_key_exists('nameExample', $result)
        ) {
            $result['nameExample'] = $this->formattedNameProvider->getFormattedNameExample($result['format']);
            $context->setResult($result);
        }
    }
}
