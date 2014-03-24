<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle(),
            new Ideup\SimplePaginatorBundle\IdeupSimplePaginatorBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new EtoxMicrome\FrontendBundle\FrontendBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\ElasticaBundle\FOSElasticaBundle(),
            new EtoxMicrome\UserBundle\UserBundle(),
            new EtoxMicrome\DocumentBundle\EtoxMicromeDocumentBundle(),
            new EtoxMicrome\EntityBundle\EtoxMicromeEntityBundle(),
            new EtoxMicrome\Entity2DocumentBundle\EtoxMicromeEntity2DocumentBundle(),
            new EtoxMicrome\MeshTermBundle\EtoxMicromeMeshTermBundle(),
            new EtoxMicrome\ToxicEndpointBundle\EtoxMicromeToxicEndpointBundle(),
            new EtoxMicrome\Entity2AbstractBundle\EtoxMicromeEntity2AbstractBundle(),
            new EtoxMicrome\ElasticSearchBundle\EtoxMicromeElasticSearchBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
