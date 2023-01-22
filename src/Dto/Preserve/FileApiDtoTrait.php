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

use Evrinoma\DtoCommon\ValueObject\Preserve\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\BriefTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\ImageTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\PositionTrait;
use Evrinoma\GalleryBundle\DtoCommon\ValueObject\Preserve\GalleryApiDtoTrait;

trait FileApiDtoTrait
{
    use ActiveTrait;
    use BriefTrait;
    use DescriptionTrait;
    use GalleryApiDtoTrait;
    use IdTrait;
    use ImageTrait;
    use PositionTrait;
}
