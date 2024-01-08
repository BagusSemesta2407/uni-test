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
            'user' => 'bagus',
            'todolist' => [
                [
                    'id'  => '1',
                    'todo' => 'bagus',
                ],
                [
                    'id'  => '2',
                    'todo' => 'semesta',
                ],
            ]
        ])->get('/todolist')
        ->assertSeeText('1')
        ->assertSeeText('bagus')
        ->assertSeeText('2')
        ->assertSeeText('semesta');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'bagus',
        ])->post('/todolist', [])
        ->assertSeeText('Todo is required');
    }
}
