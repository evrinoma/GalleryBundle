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

use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Type\TypeInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @throws TypeInvalidException
     */
    public function onPost(TypeApiDtoInterface $dto): void;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @throws TypeInvalidException
     */
    public function onPut(TypeApiDtoInterface $dto): void;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @throws TypeInvalidException
     */
    public function onDelete(TypeApiDtoInterface $dto): void;
}
