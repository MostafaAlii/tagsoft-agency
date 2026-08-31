<?php
declare(strict_types=1);
namespace Authentication\Http\Resources;
use Illuminate\Http\Request;
class ClientAuthResource extends BaseAuthUserResource {
    public function toArray(Request $request): array {
        return array_merge(parent::toArray($request), [
            'companies' => $this->whenLoaded('companies'),
            'invoices'  => $this->whenLoaded('invoices'),
        ]);
    }
}