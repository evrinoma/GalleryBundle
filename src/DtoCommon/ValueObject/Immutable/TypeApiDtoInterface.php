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

use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface as BaseTypeApiDtoInterface;

interface TypeApiDtoInterface
{
    public const TYPE = BaseTypeApiDtoInterface::TYPE;

    public function hasTypeApiDto(): bool;

    public function getTypeApiDto(): BaseTypeApiDtoInterface;
}
