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

trait CommonGalleryTrait
{
    protected ?BaseGalleryInterface $gallery = null;

    public function getGallery(): ?BaseGalleryInterface
    {
        return $this->gallery;
    }

    public function setGallery(BaseGalleryInterface $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function resetGallery(): self
    {
        $this->gallery = null;

        return $this;
    }
}
