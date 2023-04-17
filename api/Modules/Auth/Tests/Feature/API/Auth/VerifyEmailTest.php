<?php

namespace Modules\Auth\Tests\Feature\API\Auth;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

final class VerifyEmailTest extends TestCase
{
    public function testSuccess(): void
    {
        $response = $this->postJson(route('auth.verify-email', ['token' => Uuid::uuid1()]));
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }
}
