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
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Entity\File\BaseFile;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class FileFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        0 => [
            FileApiDtoInterface::BRIEF => 'ite',
            FileApiDtoInterface::DESCRIPTION => 'description ite',
            FileApiDtoInterface::ACTIVE => 'a',
            FileApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FileApiDtoInterface::POSITION => 1,
            GalleryApiDtoInterface::GALLERY => 0,
        ],
        1 => [
            FileApiDtoInterface::BRIEF => 'kzkt',
            FileApiDtoInterface::DESCRIPTION => 'description kzkt',
            FileApiDtoInterface::ACTIVE => 'a',
            FileApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FileApiDtoInterface::POSITION => 2,
            GalleryApiDtoInterface::GALLERY => 1,
        ],
        2 => [
            FileApiDtoInterface::BRIEF => 'c2m',
            FileApiDtoInterface::DESCRIPTION => 'description c2m',
            FileApiDtoInterface::ACTIVE => 'a',
            FileApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FileApiDtoInterface::POSITION => 3,
            GalleryApiDtoInterface::GALLERY => 0,
        ],
        3 => [
            FileApiDtoInterface::BRIEF => 'kzkt2',
            FileApiDtoInterface::DESCRIPTION => 'description kzkt2',
            FileApiDtoInterface::ACTIVE => 'd',
            FileApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FileApiDtoInterface::POSITION => 4,
            GalleryApiDtoInterface::GALLERY => 1,
        ],
        4 => [
            FileApiDtoInterface::BRIEF => 'nvr',
            FileApiDtoInterface::DESCRIPTION => 'description nvr',
            FileApiDtoInterface::ACTIVE => 'b',
            FileApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FileApiDtoInterface::POSITION => 5,
            GalleryApiDtoInterface::GALLERY => 0,
        ],
        5 => [
            FileApiDtoInterface::BRIEF => 'nvr2',
            FileApiDtoInterface::DESCRIPTION => 'description nvr2',
            FileApiDtoInterface::ACTIVE => 'd',
            FileApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FileApiDtoInterface::POSITION => 6,
            GalleryApiDtoInterface::GALLERY => 1,
        ],
        6 => [
            FileApiDtoInterface::BRIEF => 'nvr3',
            FileApiDtoInterface::DESCRIPTION => 'description nvr3',
            FileApiDtoInterface::ACTIVE => 'd',
            FileApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FileApiDtoInterface::POSITION => 7,
            GalleryApiDtoInterface::GALLERY => 2,
        ],
    ];

    protected static string $class = BaseFile::class;

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
        $shortGallery = GalleryFixtures::getReferenceName();
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setGallery($this->getReference($shortGallery.$record[GalleryApiDtoInterface::GALLERY]))
                ->setActive($record[FileApiDtoInterface::ACTIVE])
                ->setBrief($record[FileApiDtoInterface::BRIEF])
                ->setPosition($record[FileApiDtoInterface::POSITION])
                ->setImage($record[FileApiDtoInterface::IMAGE])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setDescription($record[FileApiDtoInterface::DESCRIPTION])
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
            FixtureInterface::GALLERY_FILE_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 200;
    }
}
