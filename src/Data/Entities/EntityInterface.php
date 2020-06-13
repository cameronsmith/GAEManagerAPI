<?php
/**
 * Created by PhpStorm.
 * User: cameron
 * Date: 07/06/20
 * Time: 20:52
 */

namespace UKCASmith\GAEManagerAPI\Data\Entities;


interface EntityInterface
{
    /**
     * @return string
     */
    public function getEntityName();

    /**
     * @return array
     */
    public function getEntityFields();
}