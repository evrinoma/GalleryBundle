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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\FileApiDto;
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Symfony\Component\HttpFoundation\Request;

trait FileApiDtoTrait
{
    protected ?FileApiDtoInterface $fileApiDto = null;

    protected static string $classFileApiDto = FileApiDto::class;

    public function genRequestFileApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $file = $request->get(FileApiDtoInterface::FILE);
            if ($file) {
                yield $this->toRequest($file, static::$classFileApiDto);
            }
        }
    }

    public function hasFileApiDto(): bool
    {
        return null !== $this->fileApiDto;
    }

    public function getFileApiDto(): FileApiDtoInterface
    {
        return $this->fileApiDto;
    }
}
