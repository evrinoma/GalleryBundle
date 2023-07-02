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

use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Type\TypeCannotBeCreatedException;
use Evrinoma\GalleryBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\GalleryBundle\Exception\Type\TypeCannotBeSavedException;
use Evrinoma\GalleryBundle\Model\Type\TypeInterface;

interface CommandMediatorInterface
{
    /**
     * @param TypeApiDtoInterface $dto
     * @param TypeInterface       $entity
     *
     * @return TypeInterface
     *
     * @throws TypeCannotBeSavedException
     */
    public function onUpdate(TypeApiDtoInterface $dto, TypeInterface $entity): TypeInterface;

    /**
     * @param TypeApiDtoInterface $dto
     * @param TypeInterface       $entity
     *
     * @throws TypeCannotBeRemovedException
     */
    public function onDelete(TypeApiDtoInterface $dto, TypeInterface $entity): void;

    /**
     * @param TypeApiDtoInterface $dto
     * @param TypeInterface       $entity
     *
     * @return TypeInterface
     *
     * @throws TypeCannotBeSavedException
     * @throws TypeCannotBeCreatedException
     */
    public function onCreate(TypeApiDtoInterface $dto, TypeInterface $entity): TypeInterface;
}
