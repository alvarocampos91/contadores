<?php

namespace App\JsonApi\CoFoliosMovimientos;

use CloudCreativity\LaravelJsonApi\Queue\AsyncSchema;
use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{
    use AsyncSchema;

    /**
     * @var string
     */
    protected $resourceType = 'co-folios-movimientos';

    /**
     * @param \App\Models\Contador\CoFoliosMovimiento $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Contador\CoFoliosMovimiento $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return $resource->except('id')->toArray();
    }
}
