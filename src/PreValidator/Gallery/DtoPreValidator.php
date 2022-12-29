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

namespace Evrinoma\GalleryBundle\PreValidator\Gallery;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkImage($dto)
            ->checkPreview($dto)
            ->checkTitle($dto)
            ->checkFile($dto)
            ->checkDescription($dto)
            ->checkPosition($dto)
            ->checkGallery($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkId($dto)
            ->checkImage($dto)
            ->checkPreview($dto)
            ->checkTitle($dto)
            ->checkFile($dto)
            ->checkDescription($dto)
            ->checkActive($dto)
            ->checkPosition($dto)
            ->checkGallery($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this
            ->checkId($dto);
    }

    private function checkDescription(DtoInterface $dto): self
    {
        /** @var GalleryApiDtoInterface $dto */
        if (!$dto->hasDescription()) {
            throw new GalleryInvalidException('The Dto has\'t description');
        }

        return $this;
    }

    private function checkPosition(DtoInterface $dto): self
    {
        /** @var GalleryApiDtoInterface $dto */
        if (!$dto->hasPosition()) {
            throw new GalleryInvalidException('The Dto has\'t position');
        }

        return $this;
    }

    private function checkTitle(DtoInterface $dto): self
    {
        /** @var GalleryApiDtoInterface $dto */
        if (!$dto->hasTitle()) {
            throw new GalleryInvalidException('The Dto has\'t title');
        }

        return $this;
    }

    private function checkImage(DtoInterface $dto): self
    {
        /** @var GalleryApiDtoInterface $dto */
        if (!$dto->hasImage()) {
            throw new GalleryInvalidException('The Dto has\'t Image file');
        }

        return $this;
    }

    private function checkFile(DtoInterface $dto): self
    {
        /** @var GalleryApiDtoInterface $dto */
        if (!$dto->hasFileApiDto()) {
            throw new GalleryInvalidException('The Dto has\'t type');
        }

        return $this;
    }

    private function checkActive(DtoInterface $dto): self
    {
        /** @var GalleryApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new GalleryInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    private function checkGallery(DtoInterface $dto): self
    {
        /* @var GalleryApiDtoInterface $dto */

        return $this;
    }

    private function checkPreview(DtoInterface $dto): self
    {
        /** @var GalleryApiDtoInterface $dto */
        if (!$dto->hasPreview()) {
            throw new GalleryInvalidException('The Dto has\'t Preview file');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var GalleryApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new GalleryInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
