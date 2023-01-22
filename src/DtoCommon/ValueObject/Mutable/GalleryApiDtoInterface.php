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

namespace Evrinoma\GalleryBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface as BaseGalleryApiDtoInterface;

interface GalleryApiDtoInterface
{
    public function setGalleryApiDto(BaseGalleryApiDtoInterface $galleryApiDto): DtoInterface;
}
