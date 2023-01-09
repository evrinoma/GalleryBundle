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

namespace Evrinoma\GalleryBundle\Mediator\File;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\File\FileCannotBeCreatedException;
use Evrinoma\GalleryBundle\Exception\File\FileCannotBeSavedException;
use Evrinoma\GalleryBundle\Manager\Gallery\QueryManagerInterface as GalleryQueryManagerInterface;
use Evrinoma\GalleryBundle\Model\File\FileInterface;
use Evrinoma\GalleryBundle\System\FileSystemInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    private FileSystemInterface $fileSystem;
    private GalleryQueryManagerInterface $galleryQueryManager;

    public function __construct(FileSystemInterface $fileSystem, GalleryQueryManagerInterface $galleryQueryManager)
    {
        $this->fileSystem = $fileSystem;
        $this->galleryQueryManager = $galleryQueryManager;
    }

    public function onUpdate(DtoInterface $dto, $entity): FileInterface
    {
        /* @var $dto FileApiDtoInterface */
        $fileImage = $this->fileSystem->save($dto->getImage());

        try {
            $entity->setGallery($this->galleryQueryManager->proxy($dto->getGalleryApiDto()));
        } catch (\Exception $e) {
            throw new FileCannotBeSavedException($e->getMessage());
        }

        $entity
            ->setDescription($dto->getDescription())
            ->setBrief($dto->getBrief())
            ->setPosition($dto->getPosition())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setImage($fileImage->getPathname())
            ->setActive($dto->getActive());

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity
            ->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): FileInterface
    {
        /* @var $dto FileApiDtoInterface */
        $fileImage = $this->fileSystem->save($dto->getImage());

        try {
            $entity->setGallery($this->galleryQueryManager->proxy($dto->getGalleryApiDto()));
        } catch (\Exception $e) {
            throw new FileCannotBeCreatedException($e->getMessage());
        }

        $entity
            ->setDescription($dto->getDescription())
            ->setBrief($dto->getBrief())
            ->setPosition($dto->getPosition())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setImage($fileImage->getPathname())
            ->setActiveToActive();

        return $entity;
    }
}
