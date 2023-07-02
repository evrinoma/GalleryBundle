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

namespace Evrinoma\GalleryBundle\Entity\Type;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\GalleryBundle\Model\Type\AbstractType;

/**
 * @ORM\Table(name="e_gallery_type")
 * @ORM\Entity
 */
class BaseType extends AbstractType
{
}
