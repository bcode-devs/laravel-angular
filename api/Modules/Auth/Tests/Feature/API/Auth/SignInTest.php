<?php

namespace Modules\Auth\Tests\Feature\API\Auth;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

final class SignInTest extends TestCase
{
    public function testSuccess(): void
    {
        $response = $this->postJson(route('auth.sign-in'));
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }
}
