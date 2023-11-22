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

namespace Evrinoma\GalleryBundle\PreValidator\File;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\File\FileInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkGallery($dto)
            ->checkImage($dto)
            ->checkDescription($dto)
            ->checkPosition($dto)
            ->checkBrief($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkGallery($dto)
            ->checkImage($dto)
            ->checkId($dto)
            ->checkDescription($dto)
            ->checkPosition($dto)
            ->checkBrief($dto)
            ->checkActive($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this
            ->checkId($dto);
    }

    protected function checkGallery(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasGalleryApiDto()) {
            throw new FileInvalidException('The Dto has\'t gallery');
        }

        return $this;
    }

    protected function checkActive(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new FileInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    protected function checkBrief(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasBrief()) {
            throw new FileInvalidException('The Dto has\'t brief');
        }

        return $this;
    }

    protected function checkDescription(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasDescription()) {
            throw new FileInvalidException('The Dto has\'t description');
        }

        return $this;
    }

    protected function checkId(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new FileInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }

    protected function checkPosition(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasPosition()) {
            throw new FileInvalidException('The Dto has\'t position');
        }

        return $this;
    }

    protected function checkImage(DtoInterface $dto): self
    {
        /** @var FileApiDtoInterface $dto */
        if (!$dto->hasImage()) {
            throw new FileInvalidException('The Dto has\'t Image file');
        }

        return $this;
    }
}
