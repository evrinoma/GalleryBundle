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

use Evrinoma\GalleryBundle\Dto\TypeApiDto;
use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Symfony\Component\HttpFoundation\Request;

trait TypeApiDtoTrait
{
    protected ?TypeApiDtoInterface $typeApiDto = null;

    protected static string $classTypeApiDto = TypeApiDto::class;

    public function genRequestTypeApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $type = $request->get(TypeApiDtoInterface::TYPE);
            if ($type) {
                yield $this->toRequest($type, static::$classTypeApiDto);
            }
        }
    }

    public function hasTypeApiDto(): bool
    {
        return null !== $this->typeApiDto;
    }

    public function getTypeApiDto(): TypeApiDtoInterface
    {
        return $this->typeApiDto;
    }
}
