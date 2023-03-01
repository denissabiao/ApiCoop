<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as ResourcesUser;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $messages = [
            'Cpf.required' => 'Cpf é um campo obrigatório.',
            'email.required' => 'Email é um campo obrigatório.',
            'password.required' => 'Senha é um campo obrigatório.',
            'data_nascimento.required' => 'Data Nascimento é um campo obrigatório.',
            'telefone.required' => 'Telefone é um campo obrigatório.'
        ];

        $validateUser = Validator::make(
            $request->all(),
            [
                'cpf' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'data_nascimento' => 'required|date',
                'telefone' => 'required'
            ],
            $messages
        );

        if ($validateUser->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'error' => 'Erro de validação.',
                    'message' => $validateUser->errors()
                ]
            );
        }

        try {
            $user = new User;
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $user->save();

            $token = $this->userService::getCookie($user->createToken('ApiToken')->plainTextToken);

            return response()->json([
                'status' => true,
                'message' => 'Usuário cadastrado com sucesso'
            ], 200)
                ->withCookie($token);
        } catch (\Throwable $th) {
            //throw $th;
        }



    }

    public function show(Request $request)
    {
        $user = new ResourcesUser(Auth::guard('sanctum')->user());

        return response()->json([
            'status' => true,
            'data' => $user
        ], 200);
    }

    public function update(Request $request)
    {
        try {
            $user_id = Auth::guard('sanctum')->user()->id;
            $user = User::find($user_id);
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Usuário cadastrado com sucesso'
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}