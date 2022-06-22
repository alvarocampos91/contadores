<?php

namespace App\JsonApi\QueueJobs;

use CloudCreativity\LaravelJsonApi\Queue\AsyncSchema;
use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{
    use AsyncSchema;

    /**
     * @var string
     */
    protected $resourceType = 'queue-jobs';

    /**
     * @param \App\Models\Contador\QueueJob $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Contador\QueueJob $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return $resource;
    }
}
