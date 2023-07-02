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

namespace Evrinoma\GalleryBundle\Factory\Type;

use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Entity\Type\BaseType;
use Evrinoma\GalleryBundle\Model\Type\TypeInterface;

class Factory implements FactoryInterface
{
    private static string $entityClass = BaseType::class;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     */
    public function create(TypeApiDtoInterface $dto): TypeInterface
    {
        /* @var BaseType $gallery */
        return new self::$entityClass();
    }
}
