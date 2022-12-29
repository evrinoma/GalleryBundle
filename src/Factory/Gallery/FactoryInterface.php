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
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;

interface FactoryInterface
{
    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return GalleryInterface
     */
    public function create(GalleryApiDtoInterface $dto): GalleryInterface;
}
