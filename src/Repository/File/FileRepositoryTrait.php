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

namespace Evrinoma\GalleryBundle\Repository\File;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\File\FileCannotBeSavedException;
use Evrinoma\GalleryBundle\Exception\File\FileNotFoundException;
use Evrinoma\GalleryBundle\Exception\File\FileProxyException;
use Evrinoma\GalleryBundle\Mediator\File\QueryMediatorInterface;
use Evrinoma\GalleryBundle\Model\File\FileInterface;

trait FileRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param FileInterface $file
     *
     * @return bool
     *
     * @throws FileCannotBeSavedException
     * @throws ORMException
     */
    public function save(FileInterface $file): bool
    {
        try {
            $this->persistWrapped($file);
        } catch (ORMInvalidArgumentException $e) {
            throw new FileCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param FileInterface $file
     *
     * @return bool
     */
    public function remove(FileInterface $file): bool
    {
        return true;
    }

    /**
     * @param FileApiDtoInterface $dto
     *
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function findByCriteria(FileApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $files = $this->mediator->getResult($dto, $builder);

        if (0 === \count($files)) {
            throw new FileNotFoundException('Cannot find file by findByCriteria');
        }

        return $files;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws FileNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): FileInterface
    {
        /** @var FileInterface $file */
        $file = $this->findWrapped($id);

        if (null === $file) {
            throw new FileNotFoundException("Cannot find file with id $id");
        }

        return $file;
    }

    /**
     * @param string $id
     *
     * @return FileInterface
     *
     * @throws FileProxyException
     * @throws ORMException
     */
    public function proxy(string $id): FileInterface
    {
        $file = $this->referenceWrapped($id);

        if (!$this->containsWrapped($file)) {
            throw new FileProxyException("Proxy doesn't exist with $id");
        }

        return $file;
    }
}
