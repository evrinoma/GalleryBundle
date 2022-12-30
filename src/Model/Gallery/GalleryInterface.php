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

namespace Evrinoma\GalleryBundle\Model\Gallery;

use Doctrine\Common\Collections\Collection;
use Evrinoma\GalleryBundle\Model\File\FileInterface;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\DescriptionInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\UtilsBundle\Entity\ImageInterface;
use Evrinoma\UtilsBundle\Entity\PositionInterface;
use Evrinoma\UtilsBundle\Entity\PreviewInterface;
use Evrinoma\UtilsBundle\Entity\StartInterface;
use Evrinoma\UtilsBundle\Entity\TitleInterface;

interface GalleryInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface, TitleInterface, PositionInterface, PreviewInterface, ImageInterface, DescriptionInterface, StartInterface
{
    /**
     * @param Collection|FileInterface[] $file
     *
     *  @return GalleryInterface
     */
    public function setFile($file): GalleryInterface;

    /**
     * @return Collection|FileInterface[]
     */
    public function getFile(): Collection;
}
