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

use Evrinoma\GalleryBundle\Dto\GalleryApiDto;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Tests\Functional\Helper\BaseGalleryTestTrait;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\Gallery\Active;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\Gallery\Description;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\Gallery\Id;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\Gallery\Image;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\Gallery\Position;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\Gallery\Preview;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\Gallery\Start;
use Evrinoma\GalleryBundle\Tests\Functional\ValueObject\Gallery\Title;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

class BaseGallery extends AbstractServiceTest implements BaseGalleryTestInterface
{
    use BaseGalleryTestTrait;

    public const API_GET = 'evrinoma/api/gallery';
    public const API_CRITERIA = 'evrinoma/api/gallery/criteria';
    public const API_DELETE = 'evrinoma/api/gallery/delete';
    public const API_PUT = 'evrinoma/api/gallery/save';
    public const API_POST = 'evrinoma/api/gallery/create';

    protected string $methodPut = ApiBrowserTestInterface::POST;

    protected static array $header = ['CONTENT_TYPE' => 'multipart/form-data'];
    protected bool $form = true;

    protected static function getDtoClass(): string
    {
        return GalleryApiDto::class;
    }

    protected static function defaultData(): array
    {
        static::initFiles();

        return [
            GalleryApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            GalleryApiDtoInterface::ID => Id::value(),
            GalleryApiDtoInterface::TITLE => Title::default(),
            GalleryApiDtoInterface::POSITION => Position::value(),
            GalleryApiDtoInterface::ACTIVE => Active::value(),
            GalleryApiDtoInterface::DESCRIPTION => Description::default(),
            GalleryApiDtoInterface::START => Start::default(),
            GalleryApiDtoInterface::IMAGE => Image::default(),
            GalleryApiDtoInterface::PREVIEW => Preview::default(),
        ];
    }

    public function actionPost(): void
    {
        $this->createGallery();
        $this->testResponseStatusCreated();

        static::$files = [];

        $this->createGallery();
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria([GalleryApiDtoInterface::DTO_CLASS => static::getDtoClass(), GalleryApiDtoInterface::ACTIVE => Active::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);

        $find = $this->criteria([GalleryApiDtoInterface::DTO_CLASS => static::getDtoClass(), GalleryApiDtoInterface::ID => Id::value(), GalleryApiDtoInterface::ACTIVE => Active::block(), GalleryApiDtoInterface::TITLE => Title::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria([GalleryApiDtoInterface::DTO_CLASS => static::getDtoClass(), GalleryApiDtoInterface::ACTIVE => Active::value(), GalleryApiDtoInterface::ID => Id::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([GalleryApiDtoInterface::DTO_CLASS => static::getDtoClass(), GalleryApiDtoInterface::ACTIVE => Active::delete()]);
        $this->testResponseStatusOK();
        Assert::assertCount(3, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([GalleryApiDtoInterface::DTO_CLASS => static::getDtoClass(), GalleryApiDtoInterface::ACTIVE => Active::delete(), GalleryApiDtoInterface::TITLE => Title::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find[PayloadModel::PAYLOAD]);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::ACTIVE, $find[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ACTIVE]);

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::DELETED, $delete[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ACTIVE]);
    }

    public function actionPut(): void
    {
        $query = static::getDefault([GalleryApiDtoInterface::ID => Id::value(), GalleryApiDtoInterface::TITLE => Title::value(), GalleryApiDtoInterface::POSITION => Position::value(), GalleryApiDtoInterface::DESCRIPTION => Description::value()]);

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
            GalleryApiDtoInterface::ID => Id::wrong(),
            GalleryApiDtoInterface::TITLE => Title::wrong(),
            GalleryApiDtoInterface::POSITION => Position::wrong(),
        ]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $created = $this->createGallery();
        $this->testResponseStatusCreated();
        $this->checkResult($created);

        $query = static::getDefault([GalleryApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ID], GalleryApiDtoInterface::TITLE => Title::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([GalleryApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ID], GalleryApiDtoInterface::POSITION => Position::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([GalleryApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ID], GalleryApiDtoInterface::DESCRIPTION => Description::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        unset(static::$files[static::getDtoClass()][GalleryApiDtoInterface::IMAGE]);
        $query = static::getDefault([GalleryApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ID], GalleryApiDtoInterface::IMAGE => Image::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        unset(static::$files[static::getDtoClass()][GalleryApiDtoInterface::PREVIEW]);
        $query = static::getDefault([GalleryApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ID],  GalleryApiDtoInterface::PREVIEW => Preview::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([GalleryApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ID], GalleryApiDtoInterface::PREVIEW => Preview::empty(), GalleryApiDtoInterface::IMAGE => Image::empty()]);
        static::$files[static::getDtoClass()] = [];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([GalleryApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][GalleryApiDtoInterface::ID], GalleryApiDtoInterface::IMAGE => Image::empty(), GalleryApiDtoInterface::PREVIEW => Preview::empty()]);
        static::$files = [];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createGallery();
        $this->testResponseStatusCreated();
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankTitle();
        $this->testResponseStatusUnprocessable();
    }
}
