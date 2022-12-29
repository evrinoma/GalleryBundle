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

namespace Evrinoma\GalleryBundle\Repository\Gallery;

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryNotFoundException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryProxyException;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;

interface GalleryQueryRepositoryInterface
{
    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return array
     *
     * @throws GalleryNotFoundException
     */
    public function findByCriteria(GalleryApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return GalleryInterface
     *
     * @throws GalleryNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): GalleryInterface;

    /**
     * @param string $id
     *
     * @return GalleryInterface
     *
     * @throws GalleryProxyException
     * @throws ORMException
     */
    public function proxy(string $id): GalleryInterface;
}
