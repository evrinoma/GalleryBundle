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
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeCreatedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeRemovedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeSavedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryInvalidException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryNotFoundException;
use Evrinoma\GalleryBundle\Factory\Gallery\FactoryInterface;
use Evrinoma\GalleryBundle\Mediator\Gallery\CommandMediatorInterface;
use Evrinoma\GalleryBundle\Model\Gallery\GalleryInterface;
use Evrinoma\GalleryBundle\Repository\Gallery\GalleryRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private GalleryRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private FactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    public function __construct(ValidatorInterface $validator, GalleryRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return GalleryInterface
     *
     * @throws GalleryInvalidException
     * @throws GalleryCannotBeCreatedException
     * @throws GalleryCannotBeSavedException
     */
    public function post(GalleryApiDtoInterface $dto): GalleryInterface
    {
        $gallery = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $gallery);

        $errors = $this->validator->validate($gallery);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new GalleryInvalidException($errorsString);
        }

        $this->repository->save($gallery);

        return $gallery;
    }

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @return GalleryInterface
     *
     * @throws GalleryInvalidException
     * @throws GalleryNotFoundException
     * @throws GalleryCannotBeSavedException
     */
    public function put(GalleryApiDtoInterface $dto): GalleryInterface
    {
        try {
            $gallery = $this->repository->find($dto->idToString());
        } catch (GalleryNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $gallery);

        $errors = $this->validator->validate($gallery);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new GalleryInvalidException($errorsString);
        }

        $this->repository->save($gallery);

        return $gallery;
    }

    /**
     * @param GalleryApiDtoInterface $dto
     *
     * @throws GalleryCannotBeRemovedException
     * @throws GalleryNotFoundException
     */
    public function delete(GalleryApiDtoInterface $dto): void
    {
        try {
            $gallery = $this->repository->find($dto->idToString());
        } catch (GalleryNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $gallery);
        try {
            $this->repository->remove($gallery);
        } catch (GalleryCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
