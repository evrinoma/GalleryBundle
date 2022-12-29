<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\GalleryBundle\DependencyInjection\Compiler;

use Evrinoma\GalleryBundle\EvrinomaGalleryBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServicePass extends AbstractRecursivePass
{
    private array $services = ['gallery'];

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($this->services as $alias) {
            $this->wireServices($container, $alias);
        }
    }

    private function wireServices(ContainerBuilder $container, string $name)
    {
        $servicePreValidator = $container->hasParameter('evrinoma.'.EvrinomaGalleryBundle::BUNDLE.'.'.$name.'.services.pre.validator');
        if ($servicePreValidator) {
            $servicePreValidator = $container->getParameter('evrinoma.'.EvrinomaGalleryBundle::BUNDLE.'.'.$name.'.services.pre.validator');
            $preValidator = $container->getDefinition($servicePreValidator);
            $facade = $container->getDefinition('evrinoma.'.EvrinomaGalleryBundle::BUNDLE.'.'.$name.'.gallery.facade');
            $facade->setArgument(3, $preValidator);
        }
        $serviceHandler = $container->hasParameter('evrinoma.'.EvrinomaGalleryBundle::BUNDLE.'.'.$name.'.services.handler');
        if ($serviceHandler) {
            $serviceHandler = $container->getParameter('evrinoma.'.EvrinomaGalleryBundle::BUNDLE.'.'.$name.'.services.handler');
            $handler = $container->getDefinition($serviceHandler);
            $facade = $container->getDefinition('evrinoma.'.EvrinomaGalleryBundle::BUNDLE.'.'.$name.'.facade');
            $facade->setArgument(4, $handler);
        }
        $serviceFileSystem = $container->hasParameter('evrinoma.'.EvrinomaGalleryBundle::BUNDLE.'.'.$name.'.services.system.file_system');
        if ($serviceFileSystem) {
            $serviceFileSystem = $container->getParameter('evrinoma.'.EvrinomaGalleryBundle::BUNDLE.'.'.$name.'.services.system.file_system');
            $fileSystem = $container->getDefinition($serviceFileSystem);
            $commandMediator = $container->getDefinition('evrinoma.'.EvrinomaGalleryBundle::BUNDLE.'.'.$name.'.command.mediator');
            $commandMediator->setArgument(0, $fileSystem);
        }
    }
}
