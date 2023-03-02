<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUser;
use App\Http\Resources\User as ResourcesUser;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(StoreUpdateUser $request)
    {
        $request->validated();

        try {
            $user = new User;
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $user->save();

            $tokenTest = $user->createToken('ApiToken')->plainTextToken;
            $token = $this->userService::getCookie($tokenTest);

            return response()->json([
                'status' => true,
                'token' => $tokenTest,
                'message' => 'Usuário cadastrado com sucesso'
            ], 200)
                ->withCookie($token);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Erro de validação.',
                'message' => $e->getMessage()
            ]);
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
                'message' => 'Usuário editado com sucesso'
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}