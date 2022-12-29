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

namespace Evrinoma\GalleryBundle;

use Evrinoma\GalleryBundle\DependencyInjection\Compiler\Constraint\Complex\GalleryPass;
use Evrinoma\GalleryBundle\DependencyInjection\Compiler\Constraint\Property\FilePass as PropertyFilePass;
use Evrinoma\GalleryBundle\DependencyInjection\Compiler\Constraint\Property\GalleryPass as PropertyGalleryPass;
use Evrinoma\GalleryBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\GalleryBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\GalleryBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\GalleryBundle\DependencyInjection\EvrinomaGalleryExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaGalleryBundle extends Bundle
{
    public const BUNDLE = 'gallery';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new PropertyGalleryPass())
            ->addCompilerPass(new PropertyFilePass())
            ->addCompilerPass(new GalleryPass())
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaGalleryExtension();
        }

        return $this->extension;
    }
}
