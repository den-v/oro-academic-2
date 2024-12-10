<?php

namespace Training\Bundle\UserNamingBundle\Api\Processor\GetList;

use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Training\Bundle\UserNamingBundle\Provider\UserFormattedNameProvider;

class NameExampleGetListProcessor implements ProcessorInterface
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

        if (is_array($result)) {
            foreach ($result as $key => $entityData) {
                if (array_key_exists('format', $entityData) &&
                    !array_key_exists('nameExample', $entityData)
                ) {
                    $result[$key]['nameExample'] = $this->formattedNameProvider->getFormattedNameExample($entityData['format']);
                }
            }
        }
        $context->setResult($result);
    }
}
