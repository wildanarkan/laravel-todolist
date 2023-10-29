<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {

        $this->get('/login')
            ->assertSeeText("Login");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "cill",
            "password" => "rahasia"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "cill");
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "cill"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "cill"
        ])->get('/login')
            ->assertRedirect("/");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "cill"
        ])->post('/login', [
            "user" => "cill",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }


}
