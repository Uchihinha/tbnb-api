<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'current_page' => $this->currentPage(),
            'total' => $this->total(),
            'last_page' => $this->lastPage(),
            'per_page' => (int) $this->perPage(),
            'data' => $this->items()
        ];
    }
}
