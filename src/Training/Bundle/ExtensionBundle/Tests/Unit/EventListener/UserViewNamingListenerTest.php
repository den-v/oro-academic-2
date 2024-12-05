<?php

namespace Training\Bundle\ExtensionBundle\Tests\Unit\EventListener;

use Oro\Bundle\UIBundle\View\ScrollData;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Oro\Bundle\UserBundle\Entity\User;
use Training\Bundle\ExtensionBundle\EventListener\UserViewNamingListener;
use Twig\Environment as TwigEnvironment;

class UserViewNamingListenerTest extends TestCase
{
    private UserViewNamingListener $listener;
    private MockObject|BeforeListRenderEvent $event;
    private User|MockObject $user;
    private TwigEnvironment|MockObject $twig;
    private ScrollData|MockObject $scrollData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->listener = new UserViewNamingListener();
        $this->event = $this->createMock(BeforeListRenderEvent::class);
        $this->user = $this->createMock(User::class);
        $this->twig = $this->createMock(TwigEnvironment::class);
        $this->scrollData = $this->createMock(ScrollData::class);
    }

    public function testOnUserViewWithUserEntity()
    {
        $this->event->expects($this->once())
            ->method('getEntity')
            ->willReturn($this->user);

        $this->event->expects($this->once())
            ->method('getEnvironment')
            ->willReturn($this->twig);

        $this->event->expects($this->once())
            ->method('getScrollData')
            ->willReturn($this->scrollData);

        $template = 'Rendered Template';
        $this->twig->expects($this->once())
            ->method('render')
            ->with('@TrainingExtension/User/namingData.html.twig', ['entity' => $this->user])
            ->willReturn($template);

        $this->scrollData->expects($this->once())
            ->method('addSubBlock')
            ->with(0)
            ->willReturn(1);

        $this->scrollData->expects($this->once())
            ->method('addSubBlockData')
            ->with(0, 1, $template);

        $this->listener->onUserView($this->event);
    }

    public function testOnUserViewWithNoUserEntity()
    {
        $this->event->expects($this->once())
            ->method('getEntity')
            ->willReturn(null);

        $this->event->expects($this->never())
            ->method('getEnvironment');

        $this->event->expects($this->never())
            ->method('getScrollData');

        $this->listener->onUserView($this->event);
    }
}
