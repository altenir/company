<?php

namespace App\Http\Controllers\Security;

use App\Exceptions\InvalidUserException;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function register(StoreUserRequest $request)
    // {
    //         try {
                
    //             $user = User::create([
    //                 'name' => $request->name,
    //                 'email' => $request->email,
    //                 'password' => bcrypt($request->password),
    //                 'is_active' => $request->is_active,
    //                 'is_admin' => $request->is_admin,
    //                 'acl_group_id' => $request->acl_group_id,
    //             ]);

    //             $token = $user->createToken($request->nameToken)->plainTextToken;

    //             if ($user) {
    //                 return response()->json([
    //                     'error' => false,
    //                     'token' => $token,
    //                     'user' => $user,
    //                     'message' => 'Cadastrado com sucesso!'
    //                 ], 201);
    //             } else {
    //                 throw new InvalidUserException();
    //             }
    //         } catch (\Throwable $th) {
    //             throw new InvalidUserException();
    //         }
    // }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user|| !Hash::check($fields['password'], $user->password)){
            $response = [
                'error' => true,
                'message' => 'E-mail ou Senha Inválidos',
                'token' => null
            ];
            return response($response, 200);
        } else {
            $token = $user->createToken('usuarioLogado')->plainTextToken;

            $response = [
                'error' => false,
                'user' => $user,
                'token' => $token
            ];
            return response($response, 201);
        }        
    }

    public function logout(Request $request)
    {
        // auth()->user()->tokens()->delete();
        // $user = User::where('id', $request->userId)->first();
        // $user->tokens()->where('id', '$tokenId')->delete();
        $deleted = DB::table('personal_access_tokens')->where('tokenable_id', '=', $request->user_id)->delete();

        return response([
            'message' => 'Deslogado com sucesso',
            'deleted' => $deleted,
        ], 200);
    }

    public function denied(Request $request)
    {
        return response([
            'errors' => true,
            'message' => 'Não autorizado',
        ], 401);
    }
}
