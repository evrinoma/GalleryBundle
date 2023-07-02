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

namespace Evrinoma\GalleryBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;

trait FileApiDtoTrait
{
    public function setFileApiDto(FileApiDtoInterface $fileApiDto): DtoInterface
    {
        return parent::setFileApiDto($fileApiDto);
    }
}
