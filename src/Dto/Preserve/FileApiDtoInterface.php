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

namespace Evrinoma\GalleryBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ImageInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionInterface;

interface FileApiDtoInterface extends IdInterface, BriefInterface, DescriptionInterface, ActiveInterface, ImageInterface, PositionInterface
{
    /**
     * @param GalleryApiDtoInterface $galleryApiDto
     *
     * @return DtoInterface
     */
    public function setGalleryApiDto(GalleryApiDtoInterface $galleryApiDto): DtoInterface;
}
