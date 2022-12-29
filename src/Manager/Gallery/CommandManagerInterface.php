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

namespace Evrinoma\GalleryBundle\Manager\Gallery;

use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeRemovedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryInvalidException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryNotFoundException;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;

interface CommandManagerInterface
{
    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return GalleryInterface
     *
     * @throws GalleryInvalidException
     */
    public function post(GalleryApiDtoInterface $dto): GalleryInterface;

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return GalleryInterface
     *
     * @throws GalleryInvalidException
     * @throws GalleryNotFoundException
     */
    public function put(GalleryApiDtoInterface $dto): GalleryInterface;

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @throws GalleryCannotBeRemovedException
     * @throws GalleryNotFoundException
     */
    public function delete(GalleryApiDtoInterface $dto): void;
}
