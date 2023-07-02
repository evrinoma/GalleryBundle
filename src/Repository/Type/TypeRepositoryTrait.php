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

namespace Evrinoma\GalleryBundle\Repository\Type;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Type\TypeCannotBeSavedException;
use Evrinoma\GalleryBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\GalleryBundle\Exception\Type\TypeProxyException;
use Evrinoma\GalleryBundle\Mediator\Type\QueryMediatorInterface;
use Evrinoma\GalleryBundle\Model\Type\TypeInterface;

trait TypeRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param TypeInterface $type
     *
     * @return bool
     *
     * @throws TypeCannotBeSavedException
     * @throws ORMException
     */
    public function save(TypeInterface $type): bool
    {
        try {
            $this->persistWrapped($type);
        } catch (ORMInvalidArgumentException $e) {
            throw new TypeCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param TypeInterface $type
     *
     * @return bool
     */
    public function remove(TypeInterface $type): bool
    {
        return true;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return array
     *
     * @throws TypeNotFoundException
     */
    public function findByCriteria(TypeApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $types = $this->mediator->getResult($dto, $builder);

        if (0 === \count($types)) {
            throw new TypeNotFoundException('Cannot find type by findByCriteria');
        }

        return $types;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws TypeNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): TypeInterface
    {
        /** @var TypeInterface $type */
        $type = $this->findWrapped($id);

        if (null === $type) {
            throw new TypeNotFoundException("Cannot find type with id $id");
        }

        return $type;
    }

    /**
     * @param string $id
     *
     * @return TypeInterface
     *
     * @throws TypeProxyException
     * @throws ORMException
     */
    public function proxy(string $id): TypeInterface
    {
        $type = $this->referenceWrapped($id);

        if (!$this->containsWrapped($type)) {
            throw new TypeProxyException("Proxy doesn't exist with $id");
        }

        return $type;
    }
}
