<?php

namespace Training\Bundle\ExtensionBundle\EventListener;

use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Oro\Bundle\UserBundle\Entity\User;

class UserViewNamingListener
{
    /**
     * @param BeforeListRenderEvent $event
     */
    public function onUserView(BeforeListRenderEvent $event): void
    {
        /** @var User $user */
        $user = $event->getEntity();
        if (!$user) {
            return;
        }

        $template = $event->getEnvironment()->render(
            '@TrainingExtension/User/namingData.html.twig',
            ['entity' => $user]
        );
        $scrollData = $event->getScrollData();
        $subBlockId = $scrollData->addSubBlock(0);
        $scrollData->addSubBlockData(0, $subBlockId, $template);
    }
}
