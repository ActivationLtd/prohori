<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class RecommenderApiTest extends TestCase
{

    protected $email = 'recommender@gmail.com';
    protected $password = 'prohori';
    protected $bearer_token;
    /** @var  $user User */
    protected $user;
    protected $user_api_headers;

    protected function setUp()
    {
        parent::setUp();
        $this->user = User::where('email', $this->email)->first();
        $this->bearer_token = $this->user->auth_token;
        $this->user_api_headers = array_merge($this->api_headers, ['Authorization' => 'Bearer ' . $this->bearer_token]);
    }

    /** @test */
    public function recommender_can_login()
    {
        $data = [
            'email' => $this->email,
            'password' => $this->password,
        ];
        $response = $this->withHeaders($this->api_headers)->json('POST', route('api.login'), $data);
        $response->assertStatus(200)->assertJson(['status' => 'success',]);
    }

    /** @test */
    public function new_recommender_can_social_login()
    {
        $rand = randomString();
        $avatar = "http://some.url.go/{$rand}.jpg";

        $data = [
            'social_account_id' => 'test-id-' . $rand,
            'social_account_type' => 'facebook',
            'email' => "test.new.social-{$rand}@gmail.com",
            'name' => "name {$rand}",
            'group_id' => 8,
            'avatar_url' => $avatar,
        ];

        $response = $this->withHeaders($this->api_headers)->json('POST', route('api.social-login'), $data);
        $response->assertStatus(200)->assertJson([
            'status' => 'success',
            'data' => [
                'social_account_id' => 'test-id-' . $rand,
                'avatar' => $avatar
            ],
        ]);
    }

    /** @test */
    public function user_can_update_his_profile_info()
    {
        $new_first_name = 'Test' . randomString(4);
        $data = [
            'first_name' => $new_first_name,
        ];

        //dd($this->user_api_headers);
        $response = $this->withHeaders($this->user_api_headers)->json('PATCH', route('api.user.users-patch'), $data);
        $response->assertStatus(200)->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $this->user->id,
                'first_name' => $new_first_name
            ],
        ]);
    }

}
