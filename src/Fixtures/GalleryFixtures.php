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

namespace Evrinoma\GalleryBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Entity\Gallery\BaseGallery;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class GalleryFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        0 => [
            GalleryApiDtoInterface::TITLE => 'ite',
            GalleryApiDtoInterface::POSITION => 1,
            GalleryApiDtoInterface::DESCRIPTION => 'desc',
            GalleryApiDtoInterface::ACTIVE => 'a',
            GalleryApiDtoInterface::START => '2008-10-23 10:21:50',
            GalleryApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            GalleryApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
            GalleryApiDtoInterface::TYPE => 0,
        ],
        1 => [
            GalleryApiDtoInterface::TITLE => 'kzkt',
            GalleryApiDtoInterface::POSITION => 2,
            GalleryApiDtoInterface::DESCRIPTION => 'desc',
            GalleryApiDtoInterface::ACTIVE => 'a',
            GalleryApiDtoInterface::START => '2015-10-23 10:21:50',
            GalleryApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            GalleryApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
            GalleryApiDtoInterface::TYPE => 1,
        ],
        2 => [
            GalleryApiDtoInterface::TITLE => 'c2m',
            GalleryApiDtoInterface::POSITION => 3,
            GalleryApiDtoInterface::DESCRIPTION => 'desc',
            GalleryApiDtoInterface::ACTIVE => 'a',
            GalleryApiDtoInterface::START => '2020-10-23 10:21:50',
            GalleryApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            GalleryApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
            GalleryApiDtoInterface::TYPE => 2,
        ],
        3 => [
            GalleryApiDtoInterface::TITLE => 'kzkt2',
            GalleryApiDtoInterface::POSITION => 1,
            GalleryApiDtoInterface::DESCRIPTION => 'desc',
            GalleryApiDtoInterface::ACTIVE => 'd',
            GalleryApiDtoInterface::START => '2015-10-23 10:21:50',
            GalleryApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            GalleryApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
            GalleryApiDtoInterface::TYPE => 3,
        ],
        4 => [
            GalleryApiDtoInterface::TITLE => 'nvr',
            GalleryApiDtoInterface::POSITION => 2,
            GalleryApiDtoInterface::DESCRIPTION => 'desc',
            GalleryApiDtoInterface::ACTIVE => 'b',
            GalleryApiDtoInterface::START => '2010-10-23 10:21:50',
            GalleryApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            GalleryApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
            GalleryApiDtoInterface::TYPE => 4,
        ],
        5 => [
            GalleryApiDtoInterface::TITLE => 'nvr2',
            GalleryApiDtoInterface::POSITION => 3,
            GalleryApiDtoInterface::DESCRIPTION => 'desc',
            GalleryApiDtoInterface::ACTIVE => 'd',
            GalleryApiDtoInterface::START => '2010-10-23 10:21:50',
            GalleryApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            GalleryApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
            GalleryApiDtoInterface::TYPE => 5,
        ],
        6 => [
            GalleryApiDtoInterface::TITLE => 'nvr3',
            GalleryApiDtoInterface::POSITION => 1,
            GalleryApiDtoInterface::DESCRIPTION => 'desc',
            GalleryApiDtoInterface::ACTIVE => 'd',
            GalleryApiDtoInterface::START => '2011-10-23 10:21:50',
            GalleryApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            GalleryApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
            GalleryApiDtoInterface::TYPE => 6,
        ],
    ];

    protected static string $class = BaseGallery::class;

    public static function getReferenceName(): string
    {
        return FileFixtures::getReferenceName().parent::getReferenceName();
    }

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $short = static::getReferenceName();
        $shortType = TypeFixtures::getReferenceName();
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setType($this->getReference($shortType.$record[GalleryApiDtoInterface::TYPE]))
                ->setPreview($record[GalleryApiDtoInterface::PREVIEW])
                ->setActive($record[GalleryApiDtoInterface::ACTIVE])
                ->setTitle($record[GalleryApiDtoInterface::TITLE])
                ->setPosition($record[GalleryApiDtoInterface::POSITION])
                ->setDescription($record[GalleryApiDtoInterface::DESCRIPTION])
                ->setStart(new \DateTimeImmutable($record[GalleryApiDtoInterface::START]))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setImage($record[GalleryApiDtoInterface::IMAGE])
            ;

            $this->expandEntity($entity, $record);

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            $i++;
        }

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::GALLERY_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 100;
    }
}
