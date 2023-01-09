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

namespace Evrinoma\GalleryBundle\Repository\Gallery;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeSavedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryNotFoundException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryProxyException;
use Evrinoma\GalleryBundle\Mediator\Gallery\QueryMediatorInterface;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;

trait GalleryRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param GalleryInterface $gallery
     *
     * @return bool
     *
     * @throws GalleryCannotBeSavedException
     * @throws ORMException
     */
    public function save(GalleryInterface $gallery): bool
    {
        try {
            $this->persistWrapped($gallery);
        } catch (ORMInvalidArgumentException $e) {
            throw new GalleryCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param GalleryInterface $gallery
     *
     * @return bool
     */
    public function remove(GalleryInterface $gallery): bool
    {
        return true;
    }

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return array
     *
     * @throws GalleryNotFoundException
     */
    public function findByCriteria(GalleryApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $galleries = $this->mediator->getResult($dto, $builder);

        if (0 === \count($galleries)) {
            throw new GalleryNotFoundException('Cannot find gallery by findByCriteria');
        }

        return $galleries;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws GalleryNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): GalleryInterface
    {
        /** @var GalleryInterface $gallery */
        $gallery = $this->findWrapped($id);

        if (null === $gallery) {
            throw new GalleryNotFoundException("Cannot find gallery with id $id");
        }

        return $gallery;
    }

    /**
     * @param string $id
     *
     * @return GalleryInterface
     *
     * @throws GalleryProxyException
     * @throws ORMException
     */
    public function proxy(string $id): GalleryInterface
    {
        $gallery = $this->referenceWrapped($id);

        if (!$this->containsWrapped($gallery)) {
            throw new GalleryProxyException("Proxy doesn't exist with $id");
        }

        return $gallery;
    }
}
