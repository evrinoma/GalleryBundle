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

namespace Evrinoma\GalleryBundle\Mediator\Gallery;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeCreatedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeSavedException;
use Evrinoma\GalleryBundle\Manager\Type\QueryManagerInterface as TypeQueryManagerInterface;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;
use Evrinoma\GalleryBundle\System\FileSystemInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    private FileSystemInterface $fileSystem;
    private TypeQueryManagerInterface $typeQueryManager;

    public function __construct(FileSystemInterface $fileSystem, TypeQueryManagerInterface $typeQueryManager)
    {
        $this->fileSystem = $fileSystem;
        $this->typeQueryManager = $typeQueryManager;
    }

    public function onUpdate(DtoInterface $dto, $entity): GalleryInterface
    {
        /* @var $dto GalleryApiDtoInterface */
        $filePreview = $this->fileSystem->save($dto->getPreview());
        $fileImage = $this->fileSystem->save($dto->getImage());
        $entity
            ->setDescription($dto->getDescription())
            ->setTitle($dto->getTitle())
            ->setPosition($dto->getPosition())
            ->setPreview($filePreview->getPathname())
            ->setImage($fileImage->getPathname())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

        if ($dto->hasStart()) {
            $entity->setStart(new \DateTimeImmutable($dto->getStart()));
        }

        try {
            $entity->setType($this->typeQueryManager->proxy($dto->getTypeApiDto()));
        } catch (\Exception $e) {
            throw new GalleryCannotBeSavedException($e->getMessage());
        }

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity
            ->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): GalleryInterface
    {
        /* @var $dto GalleryApiDtoInterface */
        $filePreview = $this->fileSystem->save($dto->getPreview());
        $fileImage = $this->fileSystem->save($dto->getImage());
        $entity
            ->setDescription($dto->getDescription())
            ->setTitle($dto->getTitle())
            ->setPosition($dto->getPosition())
            ->setPreview($filePreview->getPathname())
            ->setImage($fileImage->getPathname())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        if ($dto->hasStart()) {
            $entity->setStart(new \DateTimeImmutable($dto->getStart()));
        }

        try {
            $entity->setType($this->typeQueryManager->proxy($dto->getTypeApiDto()));
        } catch (\Exception $e) {
            throw new GalleryCannotBeCreatedException($e->getMessage());
        }

        return $entity;
    }
}
