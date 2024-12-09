<?php

namespace Training\Bundle\UserNamingBundle\ImportExport\TemplateFixture;

use Oro\Bundle\ImportExportBundle\TemplateFixture\AbstractTemplateRepository;
use Oro\Bundle\ImportExportBundle\TemplateFixture\TemplateFixtureInterface;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingTypeFixture extends AbstractTemplateRepository implements TemplateFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass(): string
    {
        return UserNamingType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): \Iterator|\ArrayIterator
    {
        return $this->getEntityData('Official');
    }

    /**
     * {@inheritdoc}
     */
    protected function createEntity($key)
    {
        return new UserNamingType();
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity($key)
    {
        return new UserNamingType();
    }

    /**
     * {@inheritdoc}
     */
    public function fillEntityData($key, $entity): void
    {
        switch ($key) {
            case 'Official':
                $entity
                    ->setTitle('Official')
                    ->setFormat('PREFIX FIRST MIDDLE LAST SUFFIX');

                return;
        }

        parent::fillEntityData($key, $entity);
    }
}
