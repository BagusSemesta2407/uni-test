<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {        
        parent::setUp();

        $this->todolistService = App::make(TodolistService::class);
    }

    public function testTodolist()
    {
        self::assertNotNull($this->todolistService);    
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo('1', 'Bagus');
        
        $todolist=Session::get('todolist');

        foreach ($todolist as $value) {
            # code...
            self::assertEquals('1', $value['id']);
            self::assertEquals('Bagus', $value['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistExists()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'bagus'
            ],
            [
                'id' => '2',
                'todo' => 'semesta'
            ]
            ];
        $this->todolistService->saveTodo('1', 'bagus');
        $this->todolistService->saveTodo('2', 'semesta');

        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo('1', 'bagus');
        $this->todolistService->saveTodo('2', 'semesta');

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('3');

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('1');

        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('2');

        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
