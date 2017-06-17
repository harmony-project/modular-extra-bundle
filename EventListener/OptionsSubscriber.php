<?php
/*
 * (c) Tim Goudriaan <tim@codedmonkey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\ModularExtraBundle\EventListener;

use Harmony\Bundle\ModularExtraBundle\Module\Options;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;

class OptionsSubscriber implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string
     */
    private $modularType;

    /**
     * @var string
     */
    private $optionsService;

    /**
     * @param ContainerInterface $container
     * @param string             $modularType
     * @param string             $optionsService
     */
    public function __construct(ContainerInterface $container, $modularType, $optionsService)
    {
        $this->container = $container;
        $this->modularType = $modularType;
        $this->optionsService = $optionsService;
    }

    /**
     * @return Options
     */
    public function getOptions()
    {
        /** @var Options $options */
        $options = $this->container->get($this->optionsService);

        return $options;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 8]],
        ];
    }

    /**
     * Handle actions before the kernel matches the controller.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (null === $module = $event->getRequest()->get('module')) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        if (!$accessor->isReadable($module, 'options')) {
            return;
        }

        $this->getOptions()->set($accessor->getValue($module, 'options'));
    }
}
