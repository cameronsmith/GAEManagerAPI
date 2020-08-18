<?php namespace CameronSmith\GAEManagerAPI\Test\Factories;

use CameronSmith\GAEManagerAPI\Data\Entities\Entity;
use Faker\Factory as Faker;
use CameronSmith\GAEManagerAPI\Data\Entities\Version as VersionEntity;
use CameronSmith\GAEManagerAPI\Data\Repository\VersionInterface;

class Version
{
    /**
     * @var VersionInterface
     */
    protected $obj_repo;

    /**
     * VersionFactory constructor.
     *
     * @param VersionInterface $obj_repo
     */
    public function __construct(VersionInterface $obj_repo)
    {
        $this->obj_repo = $obj_repo;
    }

    /**
     * Create factory.
     *
     * @param null|string $str_version_id
     * @return Entity
     */
    public function make($str_version_id = null) {
        $obj_faker = Faker::create();
        $obj_entity = new VersionEntity;
        $obj_entity->setVersionId($str_version_id ?? $obj_faker->numberBetween(1,1000));
        return $this->obj_repo->insert($obj_entity);
    }
}