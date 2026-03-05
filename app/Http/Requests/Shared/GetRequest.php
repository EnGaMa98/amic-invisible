<?php

namespace App\Http\Requests\Shared;

use App\Http\Requests\BaseFormRequest;

class GetRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'sometimes|integer|min:1',
            'perPage' => 'sometimes|integer|min:1|max:100',
            'include' => 'sometimes|nullable|string',
            'filter' => 'sometimes|array',
            'sort' => 'sometimes|array',
            'sort.by' => 'sometimes|string',
            'sort.dir' => 'sometimes|string|in:asc,desc',
        ];
    }

    protected function passedValidation(): void
    {
        $include = $this->input('include');

        if (is_string($include) && $include !== '') {
            $this->merge([
                'include' => array_map('trim', explode(',', $include)),
            ]);
        } else {
            $this->merge(['include' => []]);
        }

        if (!$this->has('filter')) {
            $this->merge(['filter' => []]);
        }

        if (!$this->has('sort')) {
            $this->merge(['sort' => ['by' => 'id', 'dir' => 'desc']]);
        }

        if (!$this->has('perPage')) {
            $this->merge(['perPage' => 25]);
        }
    }
}
