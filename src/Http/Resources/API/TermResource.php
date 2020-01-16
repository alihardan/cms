<?php

namespace Statamic\Http\Resources\API;

use Illuminate\Http\Resources\Json\Resource;

class TermResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toAugmentedArray();
    }
}
