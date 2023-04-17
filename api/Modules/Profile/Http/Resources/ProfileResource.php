<?php

namespace Modules\Profile\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shared\Entities\User\User;

final class ProfileResource extends JsonResource
{
    public function toArray($request): array
    {
        /**
         * @var User $this
         */
        return [
            'id' => $this->id,
            'url' => $this->url,
            'ident' => $this->ident,
            'name' => $this->name,
            'phone' => $this->phone,
            'avatar_url' => $this->avatar_url,
            'created_at' => $this->created_at,
            'role' =>  $this->role,
         ];
    }
}
