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

namespace Evrinoma\GalleryBundle\Mediator\Type;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Model\Type\TypeInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    public function onUpdate(DtoInterface $dto, $entity): TypeInterface
    {
        /* @var $dto TypeApiDtoInterface */
        $entity
            ->setDescription($dto->getDescription())
            ->setBrief($dto->getBrief())
            ->setActive($dto->getActive());

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity
            ->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): TypeInterface
    {
        /* @var $dto TypeApiDtoInterface */
        $entity
            ->setDescription($dto->getDescription())
            ->setBrief($dto->getBrief())
            ->setActiveToActive();

        return $entity;
    }
}
