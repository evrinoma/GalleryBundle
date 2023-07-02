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

use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

trait BaseTypeTestTrait
{
    protected function assertGet(string $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createType(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createConstraintBlankBrief(): array
    {
        $query = static::getDefault([TypeApiDtoInterface::DESCRIPTION => '']);

        return $this->post($query);
    }

    protected function createConstraintBlankDescription(): array
    {
        $query = static::getDefault([TypeApiDtoInterface::BRIEF => '']);

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkGalleryType($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkGalleryType($entity): void
    {
        Assert::assertArrayHasKey(TypeApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(TypeApiDtoInterface::DESCRIPTION, $entity);
        Assert::assertArrayHasKey(TypeApiDtoInterface::BRIEF, $entity);
        Assert::assertArrayHasKey(TypeApiDtoInterface::ACTIVE, $entity);
    }
}
