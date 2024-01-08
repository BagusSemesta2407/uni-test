<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService=$userService;
    }

    public function login(): Response
    {
        return response()
        ->view("login.index", [
            "title" => "Login",

        ]);
    }

    public function processLogin(Request $request): Response|RedirectResponse
    {
        $username=$request->input('user');
        $password=$request->input('password');

        //validate
        if (empty($username) || empty($password)) {
            return response()->view("login.index", [
                "title" => "Login",
                "error" => "User or Password Is Required"
            ]);
        }

        if ($this->userService->login($username, $password )) {
            $request->session()->put("user", $username);

            return redirect("/");
        }

        return response()->view("login.index", [
            "title" => "Login",
            "error" => "User or Password wrong"
        ]);
    }

    public function processLogout(Request $request): RedirectResponse
    {
        $request->session()->forget("user");
        return redirect("/");
    }
}
