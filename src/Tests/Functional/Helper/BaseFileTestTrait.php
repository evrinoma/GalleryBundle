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

use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait BaseFileTestTrait
{
    protected static function initFiles(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'http');

        file_put_contents($path, 'my_file');

        $fileImage = new UploadedFile($path, 'my_file');

        static::$files = [
            static::getDtoClass() => [
                FileApiDtoInterface::IMAGE => $fileImage,
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

    protected function createFile(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createConstraintBlankBrief(): array
    {
        $query = static::getDefault([FileApiDtoInterface::BRIEF => '']);

        return $this->post($query);
    }

    protected function createConstraintBlankDescription(): array
    {
        $query = static::getDefault([FileApiDtoInterface::DESCRIPTION => '']);

        return $this->post($query);
    }

    protected function compareResults(array $value, array $entity, array $query): void
    {
        Assert::assertEquals($value[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ID], $entity[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ID]);
        Assert::assertEquals($query[FileApiDtoInterface::BRIEF], $entity[PayloadModel::PAYLOAD][0][FileApiDtoInterface::BRIEF]);
        Assert::assertEquals($query[FileApiDtoInterface::DESCRIPTION], $entity[PayloadModel::PAYLOAD][0][FileApiDtoInterface::DESCRIPTION]);
        Assert::assertEquals($query[FileApiDtoInterface::POSITION], $entity[PayloadModel::PAYLOAD][0][FileApiDtoInterface::POSITION]);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkGalleryFile($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkGalleryFile($entity): void
    {
        Assert::assertArrayHasKey(FileApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(FileApiDtoInterface::DESCRIPTION, $entity);
        Assert::assertArrayHasKey(FileApiDtoInterface::BRIEF, $entity);
        Assert::assertArrayHasKey(FileApiDtoInterface::ACTIVE, $entity);
        Assert::assertArrayHasKey(FileApiDtoInterface::IMAGE, $entity);
        Assert::assertArrayHasKey(FileApiDtoInterface::POSITION, $entity);
    }
}
