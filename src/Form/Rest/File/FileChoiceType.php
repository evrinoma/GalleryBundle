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

namespace Evrinoma\GalleryBundle\Form\Rest\File;

use Doctrine\DBAL\Exception\TableNotFoundException;
use Evrinoma\GalleryBundle\Dto\FileApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\File\FileNotFoundException;
use Evrinoma\GalleryBundle\Manager\File\QueryManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileChoiceType extends AbstractType
{
    protected static string $dtoClass;

    private QueryManagerInterface $queryManager;

    public function __construct(QueryManagerInterface $queryManager, string $dtoClass)
    {
        $this->queryManager = $queryManager;
        static::$dtoClass = $dtoClass;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $value = [];
            try {
                if ($options->offsetExists('data')) {
                    $criteria = $this->queryManager->criteria(new static::$dtoClass());
                    switch ($options->offsetGet('data')) {
                        case FileApiDtoInterface::BRIEF:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getBrief();
                            }
                            break;
                        default:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getId();
                            }
                    }
                } else {
                    throw new FileNotFoundException();
                }
            } catch (TableNotFoundException|FileNotFoundException $e) {
                $value = RestChoiceType::REST_CHOICES_DEFAULT;
            }

            return $value;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'file');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'fileList');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }

    public function getParent()
    {
        return RestChoiceType::class;
    }
}
