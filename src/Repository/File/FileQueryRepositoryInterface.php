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

namespace Evrinoma\GalleryBundle\Repository\File;

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\File\FileNotFoundException;
use Evrinoma\GalleryBundle\Exception\File\FileProxyException;
use Evrinoma\GalleryBundle\Model\File\FileInterface;

interface FileQueryRepositoryInterface
{
    /**
     * @param FileApiDtoInterface $dto
     *
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function findByCriteria(FileApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return FileInterface
     *
     * @throws FileNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): FileInterface;

    /**
     * @param string $id
     *
     * @return FileInterface
     *
     * @throws FileProxyException
     * @throws ORMException
     */
    public function proxy(string $id): FileInterface;
}
