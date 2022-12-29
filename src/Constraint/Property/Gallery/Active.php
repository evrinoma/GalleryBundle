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

namespace Evrinoma\GalleryBundle\Constraint\Property\Gallery;

use Evrinoma\UtilsBundle\Constraint\Property\ActiveTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

class Active implements ConstraintInterface
{
    use ActiveTrait;
}
