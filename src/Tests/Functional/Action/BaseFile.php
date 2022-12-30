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

namespace Evrinoma\GalleryBundle\Tests\Functional\Action;

use Evrinoma\GalleryBundle\Dto\FileApiDto;
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Tests\Functional\Helper\BaseFileTestTrait;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\File\Active;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\File\Brief;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\File\Description;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\File\Id;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\File\Image;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\File\Position;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

class BaseFile extends AbstractServiceTest implements BaseFileTestInterface
{
    use BaseFileTestTrait;

    public const API_GET = 'evrinoma/api/gallery/file';
    public const API_CRITERIA = 'evrinoma/api/gallery/file/criteria';
    public const API_DELETE = 'evrinoma/api/gallery/file/delete';
    public const API_PUT = 'evrinoma/api/gallery/file/save';
    public const API_POST = 'evrinoma/api/gallery/file/create';

    protected string $methodPut = ApiBrowserTestInterface::POST;

    protected static array $header = ['CONTENT_TYPE' => 'multipart/form-data'];
    protected bool $form = true;

    protected static function getDtoClass(): string
    {
        return FileApiDto::class;
    }

    protected static function defaultData(): array
    {
        static::initFiles();

        return [
            FileApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            FileApiDtoInterface::ID => Id::value(),
            FileApiDtoInterface::BRIEF => Brief::default(),
            FileApiDtoInterface::DESCRIPTION => Description::value(),
            FileApiDtoInterface::POSITION => Position::value(),
            FileApiDtoInterface::ACTIVE => Active::value(),
            FileApiDtoInterface::IMAGE => Image::default(),
            GalleryApiDtoInterface::GALLERY => BaseGallery::defaultData(),
        ];
    }

    public function actionPost(): void
    {
        $this->createFile();
        $this->testResponseStatusCreated();

        static::$files = [];
        $query = static::getDefault([FileApiDtoInterface::BRIEF => str_shuffle(Brief::value())]);

        $this->post($query);
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria([FileApiDtoInterface::DTO_CLASS => static::getDtoClass(), FileApiDtoInterface::ACTIVE => Active::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);

        $find = $this->criteria([FileApiDtoInterface::DTO_CLASS => static::getDtoClass(), FileApiDtoInterface::ID => Id::value(), FileApiDtoInterface::ACTIVE => Active::block(), FileApiDtoInterface::DESCRIPTION => Description::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria([FileApiDtoInterface::DTO_CLASS => static::getDtoClass(), FileApiDtoInterface::ACTIVE => Active::value(), FileApiDtoInterface::ID => Id::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([FileApiDtoInterface::DTO_CLASS => static::getDtoClass(), FileApiDtoInterface::ACTIVE => Active::delete()]);
        $this->testResponseStatusOK();
        Assert::assertCount(3, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([FileApiDtoInterface::DTO_CLASS => static::getDtoClass(), FileApiDtoInterface::ACTIVE => Active::delete(), FileApiDtoInterface::DESCRIPTION => Description::default()]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find[PayloadModel::PAYLOAD]);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::ACTIVE, $find[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ACTIVE]);

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::DELETED, $delete[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ACTIVE]);
    }

    public function actionPut(): void
    {
        $query = static::getDefault([FileApiDtoInterface::ID => Id::value(), FileApiDtoInterface::DESCRIPTION => Description::value(), FileApiDtoInterface::BRIEF => Brief::value()]);

        $find = $this->assertGet(Id::value());

        $updated = $this->put($query);
        $this->testResponseStatusOK();

        $this->compareResults($find, $updated, $query);

        static::$files = [];

        $updated = $this->put($query);
        $this->testResponseStatusOK();

        $this->compareResults($find, $updated, $query);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete(Id::empty());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault([
            FileApiDtoInterface::ID => Id::wrong(),
            FileApiDtoInterface::DESCRIPTION => Description::wrong(),
            FileApiDtoInterface::BRIEF => Brief::wrong(),
        ]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $created = $this->createFile();
        $this->testResponseStatusCreated();
        $this->checkResult($created);

        $query = static::getDefault([FileApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ID], FileApiDtoInterface::BRIEF => Brief::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([FileApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ID], FileApiDtoInterface::POSITION => Position::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([FileApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ID], FileApiDtoInterface::DESCRIPTION => Description::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        unset(static::$files[static::getDtoClass()][FileApiDtoInterface::IMAGE]);
        $query = static::getDefault([FileApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ID], FileApiDtoInterface::IMAGE => Image::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([FileApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ID], FileApiDtoInterface::IMAGE => Image::empty()]);
        static::$files[static::getDtoClass()] = [];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([FileApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ID], FileApiDtoInterface::IMAGE => Image::empty()]);
        static::$files = [];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $created = $this->createFile();
        $this->testResponseStatusCreated();

        static::$files = [];

        $this->createFile();
        $this->testResponseStatusConflict();

        $query = static::getDefault([FileApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FileApiDtoInterface::ID], FileApiDtoInterface::BRIEF => Brief::value()]);

        $this->put($query);
        $this->testResponseStatusConflict();
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankBrief();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankDescription();
        $this->testResponseStatusUnprocessable();
    }
}
