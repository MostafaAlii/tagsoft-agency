<?php
declare(strict_types=1);
namespace Authentication\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class ProfileResource extends JsonResource {
    public function toArray(Request $request): array {
        return array_merge(
            ['uuid' => $this->uuid],
            $this->except(['id', 'uuid', 'created_at', 'updated_at'])
        );
    }
}