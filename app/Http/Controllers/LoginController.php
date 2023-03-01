<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function login(Request $request)
    {

        $messages = [
            'email.required' => 'Email é um campo obrigatório.',
            'password.required' => 'Senha é um campo obrigatório.',
        ];

        $validateUser = Validator::make(
            $request->only('email', 'password'),
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            $messages
        );

        if ($validateUser->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Erro de validação.',
                    'errors' => $validateUser->errors(),
                ],
                401
            );
        }

        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()
                ->json(
                    [
                        'status' => false,
                        'message' => 'Login ou senha inválidas.',
                    ],
                    401
                );
        }


        $user = User::find(auth()->user()->id);
        $token = $this->userService::getCookie($user->createToken('ApiToken')->plainTextToken);


        return response()->json([
            'status' => true,
            'message' => 'Login efetuado com sucesso'
        ], 200)
            ->withCookie($token);
    }



}