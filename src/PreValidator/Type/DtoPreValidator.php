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

namespace Evrinoma\GalleryBundle\PreValidator\Type;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Type\TypeInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkDescriptiony($dto)
            ->checkBrief($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkId($dto)
            ->checkDescriptiony($dto)
            ->checkBrief($dto)
            ->checkActive($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this
            ->checkId($dto);
    }

    private function checkActive(DtoInterface $dto): self
    {
        /** @var TypeApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new TypeInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    private function checkBrief(DtoInterface $dto): self
    {
        /** @var TypeApiDtoInterface $dto */
        if (!$dto->hasBrief()) {
            throw new TypeInvalidException('The Dto has\'t brief');
        }

        return $this;
    }

    private function checkDescriptiony(DtoInterface $dto): self
    {
        /** @var TypeApiDtoInterface $dto */
        if (!$dto->hasDescription()) {
            throw new TypeInvalidException('The Dto has\'t description');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var TypeApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new TypeInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
