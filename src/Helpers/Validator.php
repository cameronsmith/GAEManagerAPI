<?php namespace CameronSmith\GAEManagerAPI\Helpers;

use CameronSmith\GAEManagerAPI\Http\Request;
use CameronSmith\GAEManagerAPI\Exceptions\ValidationFailed;
use JsonSchema\Validator as JsonValidator;

class Validator
{
    /**
     * Name of schema folder.
     */
    const SCHEMA_FOLDER = 'schemas';

    /**
     * Validate request.
     *
     * @param Request $obj_request
     * @return JsonValidator
     * @throws ValidationFailed
     */
    public static function validateJsonRequest(Request $obj_request) {
        $arr_data = json_decode($obj_request->getBody()->getContents());
        return static::validate($obj_request, $arr_data);
    }

    /**
     * Validate request.
     *
     * @param Request $obj_request
     * @return JsonValidator
     * @throws ValidationFailed
     */
    public static function validateQueryRequest(Request $obj_request) {
        $arr_data = (object) $obj_request->getQueryParams();
        return static::validate($obj_request, $arr_data);
    }

    /**
     * Validate.
     *
     * @param Request $obj_request
     * @param $arr_data
     * @return JsonValidator
     * @throws ValidationFailed
     */
    protected static function validate(Request $obj_request, $arr_data) {
        $str_controller = strtolower(str_ireplace('\\', DIRECTORY_SEPARATOR, $obj_request->getRequestClass()));
        $str_controller_method = strtolower($obj_request->getRequestClassMethod(). '.json');

        $str_json_path = ROOT_FOLDER
            . DIRECTORY_SEPARATOR
            . static::SCHEMA_FOLDER
            . DIRECTORY_SEPARATOR
            . $str_controller
            . DIRECTORY_SEPARATOR
            . $str_controller_method;

        if (!file_exists($str_json_path)) {
            throw new ValidationFailed('Cannot locate validate file: ' . $str_json_path);
        }

        $obj_validator = new JsonValidator;
        $obj_validator->validate($arr_data, (object)['$ref' => 'file://' . realpath($str_json_path)]);

        return $obj_validator;
    }
}