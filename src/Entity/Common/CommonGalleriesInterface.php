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

namespace Evrinoma\GalleryBundle\Entity\Common;

use Doctrine\Common\Collections\Collection;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface as BaseGalleryInterface;

interface CommonGalleriesInterface
{
    public function getGalleries(): Collection;

    public function addGallery(BaseGalleryInterface $gallery): self;

    public function removeGallery(BaseGalleryInterface $gallery): self;

    public function clearGallery(): self;
}
