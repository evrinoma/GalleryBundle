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

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping;
use Evrinoma\GalleryBundle\DependencyInjection\EvrinomaGalleryExtension;
use Evrinoma\GalleryBundle\Entity\File\BaseFile;
use Evrinoma\GalleryBundle\Entity\Type\BaseType;
use Evrinoma\GalleryBundle\Model\File\FileInterface;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;
use Evrinoma\GalleryBundle\Model\Type\TypeInterface;
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

            $entityFile = BaseFile::class;

            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/File', '%s/Entity/File');
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Type', '%s/Entity/Type');

            $this->addResolveTargetEntity(
                [
                    $entityFile => [FileInterface::class => []],
                    BaseType::class => [TypeInterface::class => []],
                ],
                false
            );

            $entityGallery = $container->getParameter('evrinoma.gallery.entity');
            if (str_contains($entityGallery, EvrinomaGalleryExtension::ENTITY)) {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Gallery', '%s/Entity/Gallery');
            }
            $this->addResolveTargetEntity([$entityGallery => [GalleryInterface::class => []]], false);

            $mapping = $this->getMapping($entityFile);
            $this->addResolveTargetEntity([$entityFile => [FileInterface::class => ['inherited' => true, 'joinTable' => $mapping]]], false);
        }
    }

    private function getMapping(string $className): array
    {
        $annotationReader = new AnnotationReader();
        $reflectionClass = new \ReflectionClass($className);
        $joinTableAttribute = $annotationReader->getClassAnnotation($reflectionClass, Mapping\Table::class);

        return ($joinTableAttribute) ? ['name' => $joinTableAttribute->name] : [];
    }
}
