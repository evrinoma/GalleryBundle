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

namespace Evrinoma\GalleryBundle\Tests\Functional\ValueObject\Type;

use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractActive;
use Evrinoma\UtilsBundle\Model\ActiveModel;

class Active extends AbstractActive
{
    protected static string $default = ActiveModel::MODERATED;
}
