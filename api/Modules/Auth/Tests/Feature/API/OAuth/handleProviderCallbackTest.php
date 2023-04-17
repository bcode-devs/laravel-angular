<?php

namespace Modules\Auth\Tests\Feature\API\OAuth;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

final class handleProviderCallbackTest extends TestCase
{
    public function testSuccess(): void
    {
        $response = $this->getJson(route('auth.oauth.callback', ['driver' => 'facebook']));

        $response->assertStatus(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }
}
