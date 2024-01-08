<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
        ->assertSeeText("Login");
    }

    public function testLoginForMember() 
    {
        $this->withSession([
            "user" => "bagus",
        ])->get('/login')
        ->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "bagus",
            "password" => "semesta",
        ])->assertRedirect("/")
        ->assertSessionHas("user", "bagus");
    }

    public function testLoginSuccessForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "bagus"
        ])->post('/login', [
            "user" => "bagus",
            "password" => "semesta",
        ])->assertRedirect("/");
    }

    public function testLoginValidationError() 
    {
        $this->post("/login", [])
        ->assertSeeText("User or Password Is Required");    
    }

    public function testLoginFailed() 
    {
        $this->post("/login", [
            "user" => "wrong",
            "password" => "wrong",
        ])->assertSeeText("User or Password wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "bagus"
        ])->post("/logout")->assertRedirect("/")->assertSessionMissing("user");    
    }

    public function testLogoutGuest()
    {
        $this->post("/logout")
        ->assertRedirect("/");    
    }
}
