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
use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\DtoCommon\ValueObject\Immutable\TypeApiDtoTrait as TypeApiDtoImmutableTrait;

trait TypeApiDtoTrait
{
    use TypeApiDtoImmutableTrait;

    /**
     * @param TypeApiDtoInterface $typeApiDto
     *
     * @return DtoInterface
     */
    public function setTypeApiDto(TypeApiDtoInterface $typeApiDto): DtoInterface
    {
        $this->typeApiDto = $typeApiDto;

        return $this;
    }
}
