<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as ResourcesUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
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
                'email' => 'required|email',
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

            $token = $user->createToken('token_access')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Usuário cadastrado com sucesso',
                'token' => $token
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $token = $request->header('Authorization');
        $user = new ResourcesUser(Auth::guard('sanctum')->user());

        return response()->json([
            'status' => true,
            'token' => $token,
            'data' => $user
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $user_id = Auth::guard('sanctum')->user()->id;
            $user = User::find($user_id);
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
            $token = $request->header('Authorization');

            return response()->json([
                'status' => true,
                'message' => 'Usuário cadastrado com sucesso',
                'token' => $token
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}