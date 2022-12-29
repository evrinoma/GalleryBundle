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

namespace Evrinoma\GalleryBundle\Repository\Orm\Gallery;

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\GalleryBundle\Mediator\Gallery\QueryMediatorInterface;
use Evrinoma\GalleryBundle\Repository\Gallery\GalleryRepositoryInterface;
use Evrinoma\GalleryBundle\Repository\Gallery\GalleryRepositoryTrait;
use Evrinoma\UtilsBundle\Repository\Orm\RepositoryWrapper;
use Evrinoma\UtilsBundle\Repository\RepositoryWrapperInterface;

class GalleryRepository extends RepositoryWrapper implements GalleryRepositoryInterface, RepositoryWrapperInterface
{
    use GalleryRepositoryTrait;

    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }
}
