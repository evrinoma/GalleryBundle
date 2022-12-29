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

namespace Evrinoma\GalleryBundle\Manager\Gallery;

use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryNotFoundException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryProxyException;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;
use Evrinoma\GalleryBundle\Repository\Gallery\GalleryQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private GalleryQueryRepositoryInterface $repository;

    public function __construct(GalleryQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return array
     *
     * @throws GalleryNotFoundException
     */
    public function criteria(GalleryApiDtoInterface $dto): array
    {
        try {
            $gallery = $this->repository->findByCriteria($dto);
        } catch (GalleryNotFoundException $e) {
            throw $e;
        }

        return $gallery;
    }

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return GalleryInterface
     *
     * @throws GalleryProxyException
     */
    public function proxy(GalleryApiDtoInterface $dto): GalleryInterface
    {
        try {
            if ($dto->hasId()) {
                $gallery = $this->repository->proxy($dto->idToString());
            } else {
                throw new GalleryProxyException('Id value is not set while trying get proxy object');
            }
        } catch (GalleryProxyException $e) {
            throw $e;
        }

        return $gallery;
    }

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return GalleryInterface
     *
     * @throws GalleryNotFoundException
     */
    public function get(GalleryApiDtoInterface $dto): GalleryInterface
    {
        try {
            $gallery = $this->repository->find($dto->idToString());
        } catch (GalleryNotFoundException $e) {
            throw $e;
        }

        return $gallery;
    }
}
