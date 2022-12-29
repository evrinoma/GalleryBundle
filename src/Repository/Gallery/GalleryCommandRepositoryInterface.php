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

namespace Evrinoma\GalleryBundle\Repository\Gallery;

use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeRemovedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeSavedException;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;

interface GalleryCommandRepositoryInterface
{
    /**
     * @param GalleryInterface $gallery
     *
     * @return bool
     *
     * @throws GalleryCannotBeSavedException
     */
    public function save(GalleryInterface $gallery): bool;

    /**
     * @param GalleryInterface $gallery
     *
     * @return bool
     *
     * @throws GalleryCannotBeRemovedException
     */
    public function remove(GalleryInterface $gallery): bool;
}
