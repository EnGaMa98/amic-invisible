<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public static function all($resource, array $sortBy = []): array
    {
        return [
            'data' => static::collection($resource),
        ];
    }

    public static function paginate($resource, array $meta = []): array
    {
        $paginated = $resource->toArray();

        return [
            'data' => static::collection($resource),
            'meta' => array_merge([
                'current_page' => $paginated['current_page'],
                'last_page' => $paginated['last_page'],
                'per_page' => $paginated['per_page'],
                'total' => $paginated['total'],
            ], $meta),
        ];
    }
}
