<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        // Menggunakan app() untuk mendapatkan instance dari UserService
        $this->userService = app(UserService::class);
    }

    // public function testSample()
    // {
    //     self::assertTrue(true);
    // }

    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login("bagus", "semesta"));
    }

    public function testLoginUserNotFound()
    {
        self::assertFalse($this->userService->login("eko", "kuntoro"));
    }

    public function testLoginWrongPassword()
    {
        self::assertFalse($this->userService->login("bagus", "salah"));
    }
}
