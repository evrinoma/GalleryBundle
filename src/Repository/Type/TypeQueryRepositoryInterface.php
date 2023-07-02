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

namespace Evrinoma\GalleryBundle\Repository\Type;

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\GalleryBundle\Exception\Type\TypeProxyException;
use Evrinoma\GalleryBundle\Model\Type\TypeInterface;

interface TypeQueryRepositoryInterface
{
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return array
     *
     * @throws TypeNotFoundException
     */
    public function findByCriteria(TypeApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return TypeInterface
     *
     * @throws TypeNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): TypeInterface;

    /**
     * @param string $id
     *
     * @return TypeInterface
     *
     * @throws TypeProxyException
     * @throws ORMException
     */
    public function proxy(string $id): TypeInterface;
}
