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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Evrinoma\GalleryBundle\Model\File\FileInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\DescriptionTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\ImageTrait;
use Evrinoma\UtilsBundle\Entity\PositionTrait;
use Evrinoma\UtilsBundle\Entity\PreviewTrait;
use Evrinoma\UtilsBundle\Entity\StartTrait;
use Evrinoma\UtilsBundle\Entity\TitleTrait;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractGallery implements GalleryInterface
{
    use ActiveTrait;
    use CreateUpdateAtTrait;
    use DescriptionTrait;
    use IdTrait;
    use ImageTrait;
    use PositionTrait;
    use PreviewTrait;
    use StartTrait;
    use TitleTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    protected $description;

    /**
     * @var ArrayCollection|FileInterface[]
     *
     * @ORM\ManyToMany(targetEntity="Evrinoma\GalleryBundle\Model\File\FileInterface")
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="gallery_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")}
     * )
     */
    protected $file;

    public function __construct()
    {
        $this->file = new ArrayCollection();
    }

    /**
     * @return Collection|FileInterface[]
     */
    public function getFile(): Collection
    {
        return $this->file;
    }

    /**
     * @param Collection|FileInterface[] $file
     *
     *  @return GalleryInterface
     */
    public function setFile($file): GalleryInterface
    {
        $this->file = $file;

        return $this;
    }
}
