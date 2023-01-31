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

namespace Evrinoma\GalleryBundle\Model\File;

use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\BriefInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\DescriptionInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\UtilsBundle\Entity\ImageInterface;

interface FileInterface extends ActiveInterface, IdInterface, DescriptionInterface, BriefInterface, CreateUpdateAtInterface, ImageInterface
{
    public function resetGallery(): FileInterface;

    public function hasGallery(): bool;

    public function getGallery(): GalleryInterface;

    public function setGallery(GalleryInterface $gallery): FileInterface;
}
