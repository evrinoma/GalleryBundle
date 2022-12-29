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

namespace Evrinoma\GalleryBundle\Serializer;

interface GroupInterface
{
    public const API_POST_GALLERY = 'API_POST_GALLERY';
    public const API_PUT_GALLERY = 'API_PUT_GALLERY';
    public const API_GET_GALLERY = 'API_GET_GALLERY';
    public const API_CRITERIA_GALLERY = self::API_GET_GALLERY;
    public const APP_GET_BASIC_GALLERY = 'APP_GET_BASIC_GALLERY';

    public const API_POST_GALLERY_FILE = 'API_POST_GALLERY_FILE';
    public const API_PUT_GALLERY_FILE = 'API_PUT_GALLERY_FILE';
    public const API_GET_GALLERY_FILE = 'API_GET_GALLERY_FILE';
    public const API_CRITERIA_GALLERY_FILE = self::API_GET_GALLERY_FILE;
    public const APP_GET_BASIC_GALLERY_FILE = 'APP_GET_BASIC_GALLERY_FILE';
}
