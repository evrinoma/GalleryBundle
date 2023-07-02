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

namespace Evrinoma\GalleryBundle\Manager\Type;

use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\GalleryBundle\Exception\Type\TypeInvalidException;
use Evrinoma\GalleryBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\GalleryBundle\Model\Type\TypeInterface;

interface CommandManagerInterface
{
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     *
     * @throws TypeInvalidException
     */
    public function post(TypeApiDtoInterface $dto): TypeInterface;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     *
     * @throws TypeInvalidException
     * @throws TypeNotFoundException
     */
    public function put(TypeApiDtoInterface $dto): TypeInterface;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @throws TypeCannotBeRemovedException
     * @throws TypeNotFoundException
     */
    public function delete(TypeApiDtoInterface $dto): void;
}
