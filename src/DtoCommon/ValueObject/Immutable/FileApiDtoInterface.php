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

namespace Evrinoma\GalleryBundle\DtoCommon\ValueObject\Immutable;

use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface as BaseFileApiDtoInterface;

interface FileApiDtoInterface
{
    public const FILE = BaseFileApiDtoInterface::FILE;

    public function hasFileApiDto(): bool;

    public function getFileApiDto(): BaseFileApiDtoInterface;
}
