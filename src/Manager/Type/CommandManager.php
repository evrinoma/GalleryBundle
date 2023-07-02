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
use Evrinoma\GalleryBundle\Exception\Type\TypeCannotBeCreatedException;
use Evrinoma\GalleryBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\GalleryBundle\Exception\Type\TypeCannotBeSavedException;
use Evrinoma\GalleryBundle\Exception\Type\TypeInvalidException;
use Evrinoma\GalleryBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\GalleryBundle\Factory\Type\FactoryInterface;
use Evrinoma\GalleryBundle\Mediator\Type\CommandMediatorInterface;
use Evrinoma\GalleryBundle\Model\Type\TypeInterface;
use Evrinoma\GalleryBundle\Repository\Type\TypeRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private TypeRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private FactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    /**
     * @param ValidatorInterface       $validator
     * @param TypeRepositoryInterface  $repository
     * @param FactoryInterface         $factory
     * @param CommandMediatorInterface $mediator
     */
    public function __construct(ValidatorInterface $validator, TypeRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     *
     * @throws TypeInvalidException
     * @throws TypeCannotBeCreatedException
     * @throws TypeCannotBeSavedException
     */
    public function post(TypeApiDtoInterface $dto): TypeInterface
    {
        $type = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $type);

        $errors = $this->validator->validate($type);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new TypeInvalidException($errorsString);
        }

        $this->repository->save($type);

        return $type;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     *
     * @throws TypeInvalidException
     * @throws TypeNotFoundException
     * @throws TypeCannotBeSavedException
     */
    public function put(TypeApiDtoInterface $dto): TypeInterface
    {
        try {
            $type = $this->repository->find($dto->idToString());
        } catch (TypeNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $type);

        $errors = $this->validator->validate($type);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new TypeInvalidException($errorsString);
        }

        $this->repository->save($type);

        return $type;
    }

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @throws TypeCannotBeRemovedException
     * @throws TypeNotFoundException
     */
    public function delete(TypeApiDtoInterface $dto): void
    {
        try {
            $type = $this->repository->find($dto->idToString());
        } catch (TypeNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $type);
        try {
            $this->repository->remove($type);
        } catch (TypeCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
