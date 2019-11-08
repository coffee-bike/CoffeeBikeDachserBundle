<?php


namespace CoffeeBike\DachserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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
        $rootNode = $treeBuilder->root('coffee_bike_dachser');

        $rootNode
            ->children()
            ->scalarNode('dachser_branch_number')->end()
            ->scalarNode('dachser_gln_number')->end()
            ->scalarNode('dachser_branch_number_full')->end()
            ->scalarNode('dachser_sftp_host')->end()
            ->scalarNode('dachser_sftp_port')->end()
            ->scalarNode('dachser_sftp_username')->end()
            ->scalarNode('dachser_sftp_password')->end()
            ->scalarNode('dachser_sftp_remote_in_path')->end()
            ->scalarNode('dachser_sftp_remote_out_path')->end()
            ->scalarNode('dachser_sftp_remote_in_save_path')->end()
            ->scalarNode('dachser_sftp_local_in_path')->end()
            ->scalarNode('dachser_sftp_local_out_path')->end()
            ->scalarNode('dachser_sftp_local_in_save_path')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}