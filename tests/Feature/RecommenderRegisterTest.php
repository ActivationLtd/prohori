<?php

namespace Tests\Feature;

use Tests\TestCase;

class RecommenderRegisterTest extends TestCase
{
    /** @test */
    public function new_user_can_register()
    {

        $data = [
            'uuid' => 'test-' . uuid(),
            'first_name' => 'First ' . randomString(),
            'last_name' => 'Last ' . randomString(),
            'email' => 'test_' . randomString() . '@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'country_id' => 187,
            'group_id' => 8,
        ];
        $response = $this->withHeaders($this->api_headers)->json('POST', route('api.register'), $data);

        // $content = $response->json();
        // dd($content['status']);

        $response->assertStatus(200)->assertJson([
            'status' => 'success',
            'data' => [
                'groups' => [
                    ['id' => 8]
                ]
            ],
        ]);

    }
}
