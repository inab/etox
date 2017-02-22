<?php

// EtoxMicrome\Entity2DocumentBundle\DependencyInjection/Compiler/MyLoggerCompilerPass.php;


namespace EtoxMicrome\Entity2DocumentBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MyLoggerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('doctrine.dbal.logger');
        $definition
            ->setArguments(array(new Reference('my_logger')))
            ->clearTags();
    }
}