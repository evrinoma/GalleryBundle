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

namespace Evrinoma\GalleryBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\ImageTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\PreviewTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\StartTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\TitleTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class GalleryApiDto extends AbstractDto implements GalleryApiDtoInterface
{
    use ActiveTrait;
    use DescriptionTrait;
    use IdTrait;
    use ImageTrait;
    use PositionTrait;
    use PreviewTrait;
    use StartTrait;
    use TitleTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id = $request->get(GalleryApiDtoInterface::ID);
            $active = $request->get(GalleryApiDtoInterface::ACTIVE);
            $title = $request->get(GalleryApiDtoInterface::TITLE);
            $position = $request->get(GalleryApiDtoInterface::POSITION);
            $description = $request->get(GalleryApiDtoInterface::DESCRIPTION);
            $start = $request->get(GalleryApiDtoInterface::START);

            $files = ($request->files->has($this->getClass())) ? $request->files->get($this->getClass()) : [];

            try {
                if (\array_key_exists(GalleryApiDtoInterface::IMAGE, $files)) {
                    $image = $files[GalleryApiDtoInterface::IMAGE];
                } else {
                    $image = $request->get(GalleryApiDtoInterface::IMAGE);
                    if (null !== $image) {
                        $image = new File($image);
                    }
                }
            } catch (\Exception $e) {
                $image = null;
            }

            try {
                if (\array_key_exists(GalleryApiDtoInterface::PREVIEW, $files)) {
                    $preview = $files[GalleryApiDtoInterface::PREVIEW];
                } else {
                    $preview = $request->get(GalleryApiDtoInterface::PREVIEW);
                    if (null !== $preview) {
                        $preview = new File($preview);
                    }
                }
            } catch (\Exception $e) {
                $preview = null;
            }

            if ($active) {
                $this->setActive($active);
            }
            if ($id) {
                $this->setId($id);
            }
            if ($position) {
                $this->setPosition($position);
            }
            if ($title) {
                $this->setTitle($title);
            }
            if ($preview) {
                $this->setPreview($preview);
            }
            if ($image) {
                $this->setImage($image);
            }
            if ($description) {
                $this->setDescription($description);
            }
            if ($start) {
                $this->setStart($start);
            }
        }

        return $this;
    }
}
