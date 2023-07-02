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

namespace Evrinoma\GalleryBundle\Repository;

interface AliasInterface
{
    public const GALLERY = 'gallery';
    public const GALLERIES = 'galleries';

    public const FILE = 'file';
    public const FILES = AliasInterface::FILE.'s';

    public const TYPE = 'type';
    public const TYPES = AliasInterface::TYPE.'s';
}
