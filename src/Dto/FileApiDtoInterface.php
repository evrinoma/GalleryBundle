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

namespace Evrinoma\GalleryBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ImageInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\PositionInterface;

interface FileApiDtoInterface extends DtoInterface, IdInterface, BriefInterface, DescriptionInterface, ActiveInterface, ImageInterface, PositionInterface
{
    public const FILE = 'file';

    public function hasGalleryApiDto(): bool;

    public function getGalleryApiDto(): GalleryApiDtoInterface;
}
