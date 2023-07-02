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
use Evrinoma\GalleryBundle\Dto\TypeApiDtoInterface;
use Evrinoma\GalleryBundle\Entity\Type\BaseType;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class TypeFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        0 => [
            TypeApiDtoInterface::BRIEF => 'brochure',
            TypeApiDtoInterface::DESCRIPTION => 'description brochure',
            TypeApiDtoInterface::ACTIVE => 'a',
            'created_at' => '2008-10-23 10:21:50',
        ],
        1 => [
            TypeApiDtoInterface::BRIEF => 'presentation',
            TypeApiDtoInterface::DESCRIPTION => 'description presentation',
            TypeApiDtoInterface::ACTIVE => 'a',
            'created_at' => '2015-10-23 10:21:50',
        ],
        2 => [
            TypeApiDtoInterface::BRIEF => 'document',
            TypeApiDtoInterface::DESCRIPTION => 'description document',
            TypeApiDtoInterface::ACTIVE => 'a',
            'created_at' => '2020-10-23 10:21:50',
        ],
        3 => [
            TypeApiDtoInterface::BRIEF => 'certificate',
            TypeApiDtoInterface::DESCRIPTION => 'description certificate',
            TypeApiDtoInterface::ACTIVE => 'd',
            'created_at' => '2015-10-23 10:21:50',
            ],
        4 => [
            TypeApiDtoInterface::BRIEF => 'issuer',
            TypeApiDtoInterface::DESCRIPTION => 'description issuer',
            TypeApiDtoInterface::ACTIVE => 'b',
            'created_at' => '2010-10-23 10:21:50',
        ],
        5 => [
            TypeApiDtoInterface::BRIEF => 'gost',
            TypeApiDtoInterface::DESCRIPTION => 'description asrtifactgost',
            TypeApiDtoInterface::ACTIVE => 'd',
            'created_at' => '2010-10-23 10:21:50',
            ],
        6 => [
            TypeApiDtoInterface::BRIEF => 'artifact',
            TypeApiDtoInterface::DESCRIPTION => 'description artifact',
            TypeApiDtoInterface::ACTIVE => 'd',
            'created_at' => '2011-10-23 10:21:50',
        ],
    ];

    protected static string $class = BaseType::class;

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
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setActive($record[TypeApiDtoInterface::ACTIVE])
                ->setBrief($record[TypeApiDtoInterface::BRIEF])
                ->setDescription($record[TypeApiDtoInterface::DESCRIPTION])
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
            FixtureInterface::GALLERY_TYPE_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}
