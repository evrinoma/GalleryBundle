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

namespace Evrinoma\GalleryBundle\Factory\Gallery;

use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Entity\Gallery\BaseGallery;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;

class Factory implements FactoryInterface
{
    private static string $entityClass = BaseGallery::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return GalleryInterface
     */
    public function create(GalleryApiDtoInterface $dto): GalleryInterface
    {
        /* @var BaseGallery $gallery */
        return new self::$entityClass();
    }
}
