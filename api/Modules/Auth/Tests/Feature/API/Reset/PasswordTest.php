<?php

namespace Modules\Auth\Tests\Feature\API\Reset;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

final class PasswordTest extends TestCase
{
    public function testSuccess(): void
    {
        $response = $this->postJson(route('auth.reset.password'));
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }
}
