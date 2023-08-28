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

use Evrinoma\GalleryBundle\Dto\GalleryApiDto;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Symfony\Component\HttpFoundation\Request;

trait GalleryApiDtoTrait
{
    protected ?GalleryApiDtoInterface $galleryApiDto = null;

    protected static string $classGalleryApiDto = GalleryApiDto::class;

    public function genRequestGalleryApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $gallery = $request->get(GalleryApiDtoInterface::GALLERY);
            if ($gallery) {
                yield $this->toRequest($gallery, static::$classGalleryApiDto);
            }
        }
    }

    public function hasGalleryApiDto(): bool
    {
        return null !== $this->galleryApiDto;
    }

    public function getGalleryApiDto(): GalleryApiDtoInterface
    {
        return $this->galleryApiDto;
    }
}
