<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

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
        $token = $user->createToken('ApiToken');

        return response()
            ->json(
                [
                    'data' => [
                        'token' => $token->plainTextToken
                    ]
                ],
                200
            );
    }

}