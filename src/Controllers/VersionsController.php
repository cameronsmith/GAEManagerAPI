<?php namespace UKCASmith\GAEManagerAPI\Controllers;

use Slim\Http\Response;
use UKCASmith\GAEManagerAPI\Data\Entities\Version as VersionEntity;
use UKCASmith\GAEManagerAPI\Data\Repository\Datastore\Version as VersionRepo;
use UKCASmith\GAEManagerAPI\Helpers\HttpCodes;
use UKCASmith\GAEManagerAPI\Helpers\Validator;
use UKCASmith\GAEManagerAPI\Http\Request;

class VersionsController extends Controller
{
    /**
     * @var VersionRepo
     */
    protected $obj_repo;

    /**
     * VersionsController constructor.
     *
     * @param Request $request
     * @param Response $response
     * @param VersionRepo $obj_version_repo
     */
    public function __construct(
        Request $request,
        Response $response,
        VersionRepo $obj_version_repo
    )
    {
        $this->obj_repo = $obj_version_repo;
        parent::__construct($request, $response);
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
        /** @var VersionEntity $obj_entity */
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
        $str_version_id = $obj_request->version_id;

        $mix_result = $this->obj_repo->getByVersionId($str_version_id);
        if (!is_null($mix_result)) {
            return $this->respond(
                HttpCodes::HTTP_BAD_REQUEST,
                [
                    'error' => 'The version ' . $str_version_id . ' already exists.',
                ]
            );
        }

        $obj_entity = new VersionEntity;
        $obj_entity->setVersionId($str_version_id);
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

        $obj_entity = $this->obj_repo->getByVersionId($arr_vars['version_id']);
        if (is_null($obj_entity)) {
            $arr_response = [
                'error' => 'cannot locate version_id: ' . $arr_vars['version_id'],
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

        $obj_entity = $this->obj_repo->getByVersionId($arr_vars['version_id']);
        if (is_null($obj_entity)) {
            $arr_response = [
                'error' => 'cannot locate version_id: ' . $arr_vars['version_id'],
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

        $obj_entity = $this->obj_repo->getByVersionId($arr_vars['version_id']);
        if (is_null($obj_entity)) {
            $arr_response = [
                'error' => 'cannot locate version_id: ' . $arr_vars['version_id'],
            ];
            return $this->respond(HttpCodes::HTTP_NOT_FOUND, $arr_response);
        }

        $obj_vars = $this->getJsonRequestBody();
        if (!empty($obj_vars->version_id)) {
            $obj_entity->setVersionId($obj_vars->version_id);
        }

        $obj_entity = $this->obj_repo->update($obj_entity);
        return $this->respond(HttpCodes::HTTP_ACCEPTED, $obj_entity->getArray());
    }
}