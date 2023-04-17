<?php

namespace Modules\Auth\Tests\Feature\API\OAuth;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

final class RedirectToProviderTest extends TestCase
{
    public function testSuccess(): void
    {
        $response = $this->postJson(route('auth.oauth.redirect', ['driver' => 'facebook']));
        $response->assertStatus(ResponseAlias::HTTP_OK);
    }
}
