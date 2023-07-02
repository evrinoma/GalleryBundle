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

namespace Evrinoma\GalleryBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\GalleryBundle\Dto\GalleryApiDtoInterface;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryCannotBeSavedException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryInvalidException;
use Evrinoma\GalleryBundle\Exception\Gallery\GalleryNotFoundException;
use Evrinoma\GalleryBundle\Facade\Gallery\FacadeInterface;
use Evrinoma\GalleryBundle\Serializer\GroupInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class GalleryApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @Rest\Post("/api/gallery/create", options={"expose": true}, name="api_gallery_create")
     * @OA\Post(
     *     tags={"gallery"},
     *     description="the method perform create gallery",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="class", type="string", default="Evrinoma\GalleryBundle\Dto\GalleryApiDto"),
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="position", type="int"),
     *                         @OA\Property(property="start", type="string"),
     *                         @OA\Property(property="type", type="object",
     *                             @OA\Property(property="class", type="string", default="Evrinoma\GalleryBundle\Dto\TypeApiDto"),
     *                             @OA\Property(property="id", type="string", default="1"),
     *                             @OA\Property(property="brief", type="string", default="bla  bla"),
     *                         ),
     *                         @OA\Property(property="image", type="string"),
     *                         @OA\Property(property="preview", type="string"),
     *                         @OA\Property(property="Evrinoma\GalleryBundle\Dto\GalleryApiDto[image]", type="string",  format="binary"),
     *                         @OA\Property(property="Evrinoma\GalleryBundle\Dto\GalleryApiDto[preview]", type="string",  format="binary")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Create gallery")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var GalleryApiDtoInterface $galleryApiDto */
        $galleryApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_GALLERY;

        try {
            $this->facade->post($galleryApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create gallery', $json, $error);
    }

    /**
     * @Rest\Post("/api/gallery/save", options={"expose": true}, name="api_gallery_save")
     * @OA\Post(
     *     tags={"gallery"},
     *     description="the method perform save gallery for current entity",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="class", type="string", default="Evrinoma\GalleryBundle\Dto\GalleryApiDto"),
     *                         @OA\Property(property="id", type="string"),
     *                         @OA\Property(property="active", type="string"),
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="position", type="int"),
     *                         @OA\Property(property="start", type="string"),
     *                         @OA\Property(property="type", type="object",
     *                             @OA\Property(property="class", type="string", default="Evrinoma\GalleryBundle\Dto\TypeApiDto"),
     *                             @OA\Property(property="id", type="string", default="1"),
     *                             @OA\Property(property="brief", type="string", default="bla  bla"),
     *                         ),
     *                         @OA\Property(property="image", type="string"),
     *                         @OA\Property(property="preview", type="string"),
     *                         @OA\Property(property="Evrinoma\GalleryBundle\Dto\GalleryApiDto[image]", type="string",  format="binary"),
     *                         @OA\Property(property="Evrinoma\GalleryBundle\Dto\GalleryApiDto[preview]", type="string",  format="binary")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Save gallery")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var GalleryApiDtoInterface $galleryApiDto */
        $galleryApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_GALLERY;

        try {
            $this->facade->put($galleryApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save gallery', $json, $error);
    }

    /**
     * @Rest\Delete("/api/gallery/delete", options={"expose": true}, name="api_gallery_delete")
     * @OA\Delete(
     *     tags={"gallery"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\GalleryBundle\Dto\GalleryApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Delete gallery")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var GalleryApiDtoInterface $galleryApiDto */
        $galleryApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($galleryApiDto, '', $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete gallery', $json, $error);
    }

    /**
     * @Rest\Get("/api/gallery/criteria", options={"expose": true}, name="api_gallery_criteria")
     * @OA\Get(
     *     tags={"gallery"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\GalleryBundle\Dto\GalleryApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="active",
     *         in="query",
     *         name="active",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="position",
     *         in="query",
     *         name="position",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="title",
     *         in="query",
     *         name="title",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="file[brief]",
     *         in="query",
     *         description="Type Gallery",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 ref=@Model(type=Evrinoma\GalleryBundle\Form\Rest\File\FileChoiceType::class, options={"data": "brief"})
     *             ),
     *         ),
     *         style="form"
     *     ),
     * )
     * @OA\Response(response=200, description="Return gallery")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var GalleryApiDtoInterface $galleryApiDto */
        $galleryApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_GALLERY;

        try {
            $this->facade->criteria($galleryApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get gallery', $json, $error);
    }

    /**
     * @Rest\Get("/api/gallery", options={"expose": true}, name="api_gallery")
     * @OA\Get(
     *     tags={"gallery"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\GalleryBundle\Dto\GalleryApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return gallery")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var GalleryApiDtoInterface $galleryApiDto */
        $galleryApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_GALLERY;

        try {
            $this->facade->get($galleryApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get gallery', $json, $error);
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof GalleryCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof GalleryNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof GalleryInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
    }
}
