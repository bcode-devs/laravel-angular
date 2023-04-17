<?php

namespace Modules\Profile\Http\Controllers\API\Profile;

use Modules\Profile\Http\Resources\ProfileResource;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

final class ProfileController extends Controller
{
    public function info(Request $request): ProfileResource
    {
        return new ProfileResource($request->user());
    }

    public function setting()
    {
    }
}
