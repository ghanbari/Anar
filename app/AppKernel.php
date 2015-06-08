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
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new VBee\SettingBundle\VBeeSettingBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new JMS\TranslationBundle\JMSTranslationBundle(),
            new JMS\I18nRoutingBundle\JMSI18nRoutingBundle(),
            new Anar\SuperPanelBundle\AnarSuperPanelBundle(),
            new Anar\EngineBundle\AnarEngineBundle(),
            new Anar\BlogPanelBundle\AnarBlogPanelBundle(),
            new Anar\LinkBundle\AnarLinkBundle(),
            new Anar\ProfessorBundle\AnarProfessorBundle(),
            new Anar\ContentBundle\AnarContentBundle(),
            new Anar\MenuBundle\AnarMenuBundle(),
            new Anar\HomeBundle\AnarHomeBundle(),
            new Anar\SlideShowBundle\AnarSlideShowBundle(),
//            new Anar\ComplaintBundle\AnarComplaintBundle(),
            new Anar\ContactBundle\AnarContactBundle(),
//            new Anar\MessageBundle\AnarMessageBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new JMS\CommandBundle\JMSCommandBundle();
            $bundles[] = new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
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
