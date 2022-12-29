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

use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @throws GalleryInvalidException
     */
    public function onPost(GalleryApiDtoInterface $dto): void;

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @throws GalleryInvalidException
     */
    public function onPut(GalleryApiDtoInterface $dto): void;

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @throws GalleryInvalidException
     */
    public function onDelete(GalleryApiDtoInterface $dto): void;
}
