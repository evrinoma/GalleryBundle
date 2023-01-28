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

namespace Evrinoma\GalleryBundle\Repository\File;

use Evrinoma\GalleryBundle\Exception\File\FileCannotBeRemovedException;
use Evrinoma\GalleryBundle\Exception\File\FileCannotBeSavedException;
use Evrinoma\GalleryBundle\Model\File\FileInterface;

interface FileCommandRepositoryInterface
{
    /**
     * @param FileInterface $file
     *
     * @return bool
     *
     * @throws FileCannotBeSavedException
     */
    public function save(FileInterface $file): bool;

    /**
     * @param FileInterface $file
     *
     * @return bool
     *
     * @throws FileCannotBeRemovedException
     */
    public function remove(FileInterface $type): bool;
}
