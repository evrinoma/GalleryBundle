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

use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface as BaseGalleryInterface;

interface CommonGalleryInterface
{
    public function getGallery(): ?BaseGalleryInterface;

    public function setGallery(BaseGalleryInterface $gallery): self;

    public function resetGallery(): self;
}
