<?php
/*
 * This file is part of the Harmony package.
 *
 * (c) Tim Goudriaan <tim@harmony-project.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\ModularExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Validates and merges configuration for the bundle.
 *
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('harmony_modular_extra');

        $rootNode
            ->children()
                ->arrayNode('twig')
                    ->info('twig configuration')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('base_template')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->defaultValue('base.html.twig')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
