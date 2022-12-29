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

use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeCreatedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeRemovedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeSavedException;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;

interface CommandMediatorInterface
{
    /**
     * @param GalleryApiDtoInterface $dto
     * @param GalleryInterface       $entity
     *
     * @return GalleryInterface
     *
     * @throws GalleryCannotBeSavedException
     */
    public function onUpdate(GalleryApiDtoInterface $dto, GalleryInterface $entity): GalleryInterface;

    /**
     * @param GalleryApiDtoInterface $dto
     * @param GalleryInterface       $entity
     *
     * @throws GalleryCannotBeRemovedException
     */
    public function onDelete(GalleryApiDtoInterface $dto, GalleryInterface $entity): void;

    /**
     * @param GalleryApiDtoInterface $dto
     * @param GalleryInterface       $entity
     *
     * @return GalleryInterface
     *
     * @throws GalleryCannotBeSavedException
     * @throws GalleryCannotBeCreatedException
     */
    public function onCreate(GalleryApiDtoInterface $dto, GalleryInterface $entity): GalleryInterface;
}
