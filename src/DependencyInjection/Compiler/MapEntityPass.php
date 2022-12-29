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

use Evrinoma\GalleryBundle\DependencyInjection\EvrinomaGalleryExtension;
use Evrinoma\GalleryBundle\Entity\File\BaseFile;
use Evrinoma\GalleryBundle\Model\File\FileInterface;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ('orm' === $container->getParameter('evrinoma.gallery.storage')) {
            $this->setContainer($container);

            $driver = $container->findDefinition('doctrine.orm.default_metadata_driver');
            $referenceAnnotationReader = new Reference('annotations.reader');

            $this->cleanMetadata($driver, [EvrinomaGalleryExtension::ENTITY]);

            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/File', '%s/Entity/File');

            $this->addResolveTargetEntity(
                [
                    BaseFile::class => [FileInterface::class => []],
                ],
                false
            );

            $entityGallery = $container->getParameter('evrinoma.gallery.entity');
            if (str_contains($entityGallery, EvrinomaGalleryExtension::ENTITY)) {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Gallery', '%s/Entity/Gallery');
            }
            $this->addResolveTargetEntity([$entityGallery => [GalleryInterface::class => []]], false);
        }
    }
}
