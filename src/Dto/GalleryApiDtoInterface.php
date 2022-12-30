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
use Evrinoma\DtoCommon\ValueObject\Immutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ImageInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\PositionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\PreviewInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\StartInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\TitleInterface;

interface GalleryApiDtoInterface extends DtoInterface, IdInterface, TitleInterface, PositionInterface, ActiveInterface, PreviewInterface, ImageInterface, DescriptionInterface, StartInterface
{
    public const GALLERY = 'gallery';
}
