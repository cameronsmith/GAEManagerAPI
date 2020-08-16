<?php namespace CameronSmith\GAEManagerAPI\Controllers;

use CameronSmith\GAEManagerAPI\Helpers\HttpCodes;
use CameronSmith\GAEManagerAPI\Data\Repository\Datastore\Image as ImageRepo;
use CameronSmith\GAEManagerAPI\Data\Entities\Image as ImageEntity;
use CameronSmith\GAEManagerAPI\Helpers\Validator;

class ImagesController extends Controller
{
    /**
     * @var ImageRepo
     */
    protected $obj_repo;

    /**
     * ImagesController constructor.
     *
     * @param ImageRepo $obj_image_repo
     */
    public function __construct(ImageRepo $obj_image_repo)
    {
        $this->obj_repo = $obj_image_repo;
    }

    /**
     * Get all records.
     *
     * @route GET /versions
     * @return string
     */
    public function index() {
        $arr_entities = $this->obj_repo->getAll();
        $arr_response = [];
        /** @var ImageEntity $obj_entity */
        foreach($arr_entities as $obj_entity) {
            $arr_response[] = $obj_entity->getArray();
        }
        return $this->respond( HttpCodes::HTTP_OK, $arr_response);
    }

    /**
     * Create a version.
     *
     * @route POST /version/create
     * @return string
     */
    public function create() {
        $obj_validator = Validator::validateJsonRequest($this->getRequest());
        if ($obj_validator->isValid() === false) {
            return $this->respondInvalidateRequest($obj_validator);
        }

        $obj_request = $this->getJsonRequestBody();
        $str_bucket = $obj_request->bucket;
        $str_filename = $obj_request->filename;

        $mix_result = $this->obj_repo->getByBucketAndFilename($str_bucket, $str_filename);
        if (!is_null($mix_result)) {
            return $this->respond(
                HttpCodes::HTTP_BAD_REQUEST,
                [
                    'error' => 'An image already exists with the bucket: ' . $str_bucket . ' and filename: ' . $str_filename,
                ]
            );
        }

        $obj_entity = new ImageEntity;
        $obj_entity
            ->setBucket($str_bucket)
            ->setFilename($str_filename);

        $obj_entity = $this->obj_repo->insert($obj_entity);

        return $this->respond(HttpCodes::HTTP_CREATED, $obj_entity->getArray());
    }

    /**
     * Get a record.
     *
     * @route GET /versions/{version_id}
     * @return string
     */
    public function show() {
        $obj_request = $this->getRequest();
        $obj_validator = Validator::validateQueryRequest($this->getRequest());
        if ($obj_validator->isValid() === false) {
            return $this->respondInvalidateRequest($obj_validator);
        }

        $arr_vars = $obj_request->getQueryParams();

        $obj_entity = $this->obj_repo->getByKeyId($arr_vars['key_id']);
        if (is_null($obj_entity)) {
            $arr_response = [
                'error' => 'cannot locate image with key_id: ' . $arr_vars['key_id'],
            ];
            return $this->respond(HttpCodes::HTTP_NOT_FOUND, $arr_response);
        }

        return $this->respond( HttpCodes::HTTP_OK, $obj_entity->getArray());

    }

    /**
     * Delete a record.
     *
     * @route DELETE /versions/{version_id}
     * @return string
     */
    public function delete() {
        $obj_request = $this->getRequest();
        $obj_validator = Validator::validateQueryRequest($this->getRequest());
        if ($obj_validator->isValid() === false) {
            return $this->respondInvalidateRequest($obj_validator);
        }

        $arr_vars = $obj_request->getQueryParams();

        $obj_entity = $this->obj_repo->getByKeyId($arr_vars['key_id']);
        if (is_null($obj_entity)) {
            $arr_response = [
                'error' => 'cannot locate image with key_id: ' . $arr_vars['key_id'],
            ];
            return $this->respond(HttpCodes::HTTP_NOT_FOUND, $arr_response);
        }

        $this->obj_repo->delete($obj_entity->getKey());
        return $this->respond(HttpCodes::HTTP_NO_CONTENT);
    }

    /**
     * Update a record.
     *
     * @route /versions/{version_id}
     * @return string
     */
    public function update() {
        $obj_request = $this->getRequest();
        $obj_validator = Validator::validateQueryRequest($this->getRequest());
        if ($obj_validator->isValid() === false) {
            return $this->respondInvalidateRequest($obj_validator);
        }

        $arr_vars = $obj_request->getQueryParams();

        /** @var ImageEntity $obj_entity */
        $obj_entity = $this->obj_repo->getByKeyId($arr_vars['key_id']);
        if (is_null($obj_entity)) {
            $arr_response = [
                'error' => 'cannot locate image by key_id: ' . $arr_vars['key_id'],
            ];
            return $this->respond(HttpCodes::HTTP_NOT_FOUND, $arr_response);
        }

        $obj_vars = $this->getJsonRequestBody();
        $bol_update = false;
        if (!empty($obj_vars->bucket)) {
            $obj_entity->setBucket($obj_vars->bucket);
            $bol_update = true;
        }
        if (!empty($obj_vars->filename)) {
            $obj_entity->setFilename($obj_vars->filename);
            $bol_update = true;
        }

        $mix_result = $this->obj_repo->getByBucketAndFilename($obj_entity->getBucket(), $obj_entity->getFilename());
        if ($bol_update && !is_null($mix_result)) {
            return $this->respond(
                HttpCodes::HTTP_BAD_REQUEST,
                [
                    'error' =>
                        'An image already exists with the bucket: '
                        . $obj_entity->getBucket() . ' and filename: ' . $obj_entity->getFilename() . ' cannot update.',
                ]
            );
        }

        $obj_entity = $this->obj_repo->update($obj_entity);
        return $this->respond(HttpCodes::HTTP_ACCEPTED, $obj_entity->getArray());
    }
}