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

namespace Evrinoma\GalleryBundle\Mediator\File\Orm;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Evrinoma\GalleryBundle\Mediator\File\QueryMediatorInterface;
use Evrinoma\GalleryBundle\Repository\AliasInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\UtilsBundle\Mediator\Orm\QueryMediatorTrait;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
    use QueryMediatorTrait;

    protected static string $alias = AliasInterface::FILE;

    /**
     * @param DtoInterface          $dto
     * @param QueryBuilderInterface $builder
     *
     * @return mixed
     */
    public function createQuery(DtoInterface $dto, QueryBuilderInterface $builder): void
    {
        $alias = $this->alias();

        /** @var $dto FileApiDtoInterface */
        if ($dto->hasId()) {
            $builder
                ->andWhere($alias.'.id = :id')
                ->setParameter('id', $dto->getId());
        }

        if ($dto->hasBrief()) {
            $builder
                ->andWhere($alias.'.brief like :brief')
                ->setParameter('brief', '%'.$dto->getBrief().'%');
        }

        if ($dto->hasDescription()) {
            $builder
                ->andWhere($alias.'.description like :description')
                ->setParameter('description', '%'.$dto->getDescription().'%');
        }

        if ($dto->hasActive()) {
            $builder
                ->andWhere($alias.'.active = :active')
                ->setParameter('active', $dto->getActive());
        }

        $aliasGallery = AliasInterface::GALLERY;
        $builder
            ->leftJoin($alias.'.gallery', $aliasGallery)
            ->addSelect($aliasGallery);

        if ($dto->hasGalleryApiDto()) {
            if ($dto->getGalleryApiDto()->hasId()) {
                $builder->andWhere($aliasGallery.'.id = :idGallery')
                    ->setParameter('idGallery', $dto->getGalleryApiDto()->getId());
            }
        }
    }
}
