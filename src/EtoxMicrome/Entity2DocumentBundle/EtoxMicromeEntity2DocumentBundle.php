<?php

namespace EtoxMicrome\Entity2DocumentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use EtoxMicrome\Entity2DocumentBundle\DependencyInjection\Compiler\MyLoggerCompilerPass;

class EtoxMicromeEntity2DocumentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new MyLoggerCompilerPass());
    }
}
