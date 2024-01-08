<?php

namespace App\Services\Implements;

use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImplementation implements TodolistService
{
    // Implement your methods here
    public function saveTodo(string $id, string $todo) : void 
    {
        if (!Session::exists("todolist")) {
            # code...
            Session::put("todolist", []);
        }


        Session::push("todolist", [
            'id' => $id,
            'todo' => $todo
        ]);
    }

    public function getTodolist(): array
    {
        return Session::get('todolist', []);
    }

    public function removeTodo(string $todoId)
    {
        $todolist = Session::get('todolist');

        foreach ($todolist as $key => $value) {
            # code...
            if ($value['id']  == $todoId) {
                # code...
                unset($todolist[$key]);
                break;
            }
        }

        Session::put('todolist', $todolist);
    }
}