<?php

namespace Tests;

use App\Exceptions\Handler;
use App\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * @package Tests
 *
 * Exception handling was an issue so following is implemented based on JW tutorial
 * https://gist.github.com/adamwathan/125847c7e3f16b88fa33a9f8b42333da
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $x_auth_token = '4914ed65bd67e03e7e9c499e9286e00eea3982105c06ece1c32d889b636bfa62';
    protected $client_id = 905;

    /** @var  $api_headers array */
    protected $api_headers = [];

    protected function setUp()
    {
        parent::setUp();
        $this->disableExceptionHandling();
        $this->api_headers = [
            'X-Auth-Token' => $this->x_auth_token,
            'client-id' => $this->client_id,
        ];
    }

    /**
     * Short-hand function to sign in user while running test.
     *
     * @param null $user
     * @return $this
     */
    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);
        $this->actingAs($user);

        return $this;
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new class extends Handler
        {
            public function __construct() { }

            public function report(\Exception $e) { }

            public function render($request, \Exception $e)
            {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }

}
