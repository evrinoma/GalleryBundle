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

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\BriefTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\DescriptionTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\ImageTrait;
use Evrinoma\UtilsBundle\Entity\PositionTrait;

/**
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_brief", columns={"brief"})})
 */
abstract class AbstractFile implements FileInterface
{
    use ActiveTrait;
    use BriefTrait;
    use CreateUpdateAtTrait;
    use DescriptionTrait;
    use IdTrait;
    use ImageTrait;
    use PositionTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     */
    protected ?GalleryInterface $gallery = null;

    /**
     * @return GalleryInterface
     */
    public function getGallery(): GalleryInterface
    {
        return $this->gallery;
    }

    public function resetGallery(): FileInterface
    {
        $this->gallery = null;

        return $this;
    }

    /**
     * @param GalleryInterface $gallery
     *
     * @return FileInterface
     */
    public function setGallery(GalleryInterface $gallery): FileInterface
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasGallery(): bool
    {
        return null !== $this->gallery;
    }
}
