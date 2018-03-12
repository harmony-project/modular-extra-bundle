<?php
/*
 * (c) Tim Goudriaan <tim@codedmonkey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\ModularExtraBundle\DependencyInjection\Compiler;


use Harmony\Bundle\ModularExtraBundle\Module\OptionsRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class OptionsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(OptionsRegistry::class)) {
            return;
        }

        $definition     = $container->findDefinition(OptionsRegistry::class);
        $taggedServices = $container->findTaggedServiceIds('harmony_modular_extra.options');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addService', [
                    new Reference($id),
                    $attributes['modular_type'],
                    $attributes['form_type'] ?? null,
                ]);
            }
        }
    }
}
