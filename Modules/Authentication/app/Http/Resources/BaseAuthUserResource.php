<?php

declare(strict_types=1);

namespace Authentication\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseAuthUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'uuid'    => $this->uuid,
            'name'    => $this->name,
            'email'   => $this->email,
            'status'  => $this->status,
            'profile' => $this->whenLoaded('profile', fn() => new ProfileResource($this->profile)),
        ];
    }
}