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

namespace Evrinoma\GalleryBundle\Tests\Functional\Helper;

use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait BaseGalleryTestTrait
{
    protected static function initFiles(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'http');

        file_put_contents($path, 'my_file');

        $fileImage = $filePreview = new UploadedFile($path, 'my_file');

        static::$files = [
            static::getDtoClass() => [
                GalleryApiDtoInterface::IMAGE => $fileImage,
                GalleryApiDtoInterface::PREVIEW => $filePreview,
                ],
        ];
    }

    protected function assertGet(string $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createGallery(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function compareResults(array $value, array $entity, array $query): void
    {
        Assert::assertEquals($value[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ID], $entity[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ID]);
        Assert::assertEquals($query[GalleryApiDtoInterface::TITLE], $entity[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::TITLE]);
        Assert::assertEquals($query[GalleryApiDtoInterface::DESCRIPTION], $entity[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::DESCRIPTION]);
        Assert::assertEquals($query[GalleryApiDtoInterface::POSITION], $entity[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::POSITION]);
    }

    protected function createConstraintBlankTitle(): array
    {
        $query = static::getDefault([GalleryApiDtoInterface::TITLE => '']);

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkGallery($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkGallery($entity): void
    {
        Assert::assertArrayHasKey(GalleryApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(GalleryApiDtoInterface::TITLE, $entity);
        Assert::assertArrayHasKey(GalleryApiDtoInterface::ACTIVE, $entity);
        Assert::assertArrayHasKey(GalleryApiDtoInterface::PREVIEW, $entity);
        Assert::assertArrayHasKey(GalleryApiDtoInterface::POSITION, $entity);
        Assert::assertArrayHasKey(GalleryApiDtoInterface::DESCRIPTION, $entity);
        Assert::assertArrayHasKey(GalleryApiDtoInterface::START, $entity);
    }
}
