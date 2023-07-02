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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface as BaseGalleryInterface;

trait CommonGalleriesTrait
{
    protected Collection $galleries;

    public function initGalleries()
    {
        $this->galleries = new ArrayCollection();
    }

    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(BaseGalleryInterface $gallery): self
    {
        $this->galleries->add($gallery);

        return $this;
    }

    public function removeGallery(BaseGalleryInterface $gallery): self
    {
        $this->galleries->removeElement($gallery);

        return $this;
    }

    public function clearGallery(): self
    {
        $this->galleries->clear();

        return $this;
    }
}
