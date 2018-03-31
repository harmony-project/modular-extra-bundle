<?php
/*
 * (c) Tim Goudriaan <tim@codedmonkey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\ModularExtraBundle\EventListener;

use Harmony\Bundle\ModularExtraBundle\OptionsRegistry;
use Harmony\Component\ModularRouting\Manager\ModuleManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Handles events regarding module options.
 *
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
class OptionsSubscriber implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return OptionsRegistry
     */
    public function getOptionsRegistry()
    {
        /** @var OptionsRegistry $registry */
        $registry = $this->container->get(OptionsRegistry::class);

        return $registry;
    }

    /**
     * @return ModuleManagerInterface|null
     */
    public function getModuleManager()
    {
        if (!$this->container->has(ModuleManagerInterface::class)) {
            return null;
        }

        /** @var ModuleManagerInterface $manager */
        $manager = $this->container->get(ModuleManagerInterface::class);

        return $manager;
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
     * Handles actions before the kernel matches the controller.
     *
     * Sets the options of the current module dynamically.
     *
     * todo refactor without using current module functionality
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$this->getModuleManager() || null === $module = $this->getModuleManager()->getCurrentModule()) {
            return;
        }

        if (!$this->getOptionsRegistry()->has($module->getModularType())) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        if (!$accessor->isReadable($module, 'options')) {
            return;
        }

        $options = $this->getOptionsRegistry()->getOptions($module->getModularType());

        $options->set($accessor->getValue($module, 'options'));
    }
}
