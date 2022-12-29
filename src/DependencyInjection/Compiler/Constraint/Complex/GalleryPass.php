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

namespace Evrinoma\GalleryBundle\DependencyInjection\Compiler\Constraint\Complex;

use Evrinoma\GalleryBundle\Validator\GalleryValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class GalleryPass extends AbstractConstraint implements CompilerPassInterface
{
    public const GALLERY_CONSTRAINT = 'evrinoma.gallery.constraint.complex.gallery';

    protected static string $alias = self::GALLERY_CONSTRAINT;
    protected static string $class = GalleryValidator::class;
    protected static string $methodCall = 'addConstraint';
}
