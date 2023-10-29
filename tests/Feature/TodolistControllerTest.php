<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "cill",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "wildan"
                ],
                [
                    "id" => "2",
                    "todo" => "arkan"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("wildan")
            ->assertSeeText("2")
            ->assertSeeText("arkan");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "cill"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "cill"
        ])->post("/todolist", [
            "todo" => "wildan"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "cill",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "wildan"
                ],
                [
                    "id" => "2",
                    "todo" => "arkan"
                ]
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }





}