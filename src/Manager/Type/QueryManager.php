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

namespace Evrinoma\GalleryBundle\Manager\Type;

use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\GalleryBundle\Exception\Type\TypeProxyException;
use Evrinoma\GalleryBundle\Model\Type\TypeInterface;
use Evrinoma\GalleryBundle\Repository\Type\TypeQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private TypeQueryRepositoryInterface $repository;

    public function __construct(TypeQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return array
     *
     * @throws TypeNotFoundException
     */
    public function criteria(TypeApiDtoInterface $dto): array
    {
        try {
            $type = $this->repository->findByCriteria($dto);
        } catch (TypeNotFoundException $e) {
            throw $e;
        }

        return $type;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     *
     * @throws TypeProxyException
     */
    public function proxy(TypeApiDtoInterface $dto): TypeInterface
    {
        try {
            if ($dto->hasId()) {
                $type = $this->repository->proxy($dto->idToString());
            } else {
                throw new TypeProxyException('Id value is not set while trying get proxy object');
            }
        } catch (TypeProxyException $e) {
            throw $e;
        }

        return $type;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     *
     * @throws TypeNotFoundException
     */
    public function get(TypeApiDtoInterface $dto): TypeInterface
    {
        try {
            $type = $this->repository->find($dto->idToString());
        } catch (TypeNotFoundException $e) {
            throw $e;
        }

        return $type;
    }
}
