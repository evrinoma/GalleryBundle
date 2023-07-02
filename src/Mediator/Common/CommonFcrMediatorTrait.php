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

namespace Evrinoma\GalleryBundle\Mediator\Common;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\DtoCommon\ValueObject\Immutable\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Repository\AliasInterface as GalleryAliasInterface;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

trait CommonFcrMediatorTrait
{
    protected function joinGallery(DtoInterface $dto, QueryBuilderInterface $builder, string $alias): void
    {
        $aliasGallery = GalleryAliasInterface::GALLERY;
        $builder
            ->leftJoin($alias.'.gallery', $aliasGallery)
            ->addSelect($aliasGallery);
        /** @var GalleryApiDtoInterface $dto */
        if ($dto->hasGalleryApiDto() && $dto->getGalleryApiDto() && $dto->getGalleryApiDto()->hasId()) {
            $builder
                ->andWhere($aliasGallery.'.id = :idGallery')
                ->setParameter('idGallery', $dto->getGalleryApiDto()->getId());
        }
    }

    protected function joinGalleries(DtoInterface $dto, QueryBuilderInterface $builder, string $alias): void
    {
        $aliasGalleries = GalleryAliasInterface::GALLERIES;
        $builder
            ->leftJoin($alias.'.galleries', $aliasGalleries)
            ->addSelect($aliasGalleries);
        /** @var GalleryApiDtoInterface $dto */
        if ($dto->hasGalleryApiDto() && $dto->getGalleryApiDto() && $dto->getGalleryApiDto()->hasId()) {
            $builder
                ->andWhere($aliasGalleries.'.id = :idGallery')
                ->setParameter('idGallery', $dto->getGalleryApiDto()->getId());
        }
    }
}
