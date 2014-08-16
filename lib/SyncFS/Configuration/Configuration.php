<?php

namespace SyncFS\Configuration;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package SyncFS\Configuration
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('filesystem');

        $this->getConfigNode($rootNode);

        return $treeBuilder;
    }

    /**
     * @param NodeDefinition $node
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    public function getConfigNode(NodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('maps')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('src')->isRequired()->end()
                            ->scalarNode('dst')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('timeout')->defaultValue(15 * 60)->end()
            ->end()
        ->end();

        return $node;
    }
}
