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

namespace Evrinoma\GalleryBundle\Mediator\Gallery;

use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param GalleryApiDtoInterface $dto
     * @param QueryBuilderInterface  $builder
     *
     * @return mixed
     */
    public function createQuery(GalleryApiDtoInterface $dto, QueryBuilderInterface $builder): void;

    /**
     * @param GalleryApiDtoInterface $dto
     * @param QueryBuilderInterface  $builder
     *
     * @return array
     */
    public function getResult(GalleryApiDtoInterface $dto, QueryBuilderInterface $builder): array;
}
