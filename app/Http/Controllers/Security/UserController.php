<?php

namespace App\Http\Controllers\Security;

use App\Http\Resources\Security\UserResource;
use App\Models\Security\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $cpoSearch= $request->cpoSearch;
            $search = '%' . $cpoSearch . '%';
            $cpoType = $request->cpoType;


            if($cpoType == 'C'){
                $paginator = User::where('id', 'like', $search )
                ->paginate(20);
            }
            if($cpoType == 'N'){
                $paginator = User::where('name', 'like', $search )
                ->paginate(20);
            }
            if ($paginator->count() > 0) {
                return response()->json([
                    'error' => false,
                    'total' => $paginator->total(),
                    'perPage' => $paginator->perPage(),
                    'listed' => UserResource::collection($paginator->items()),
                    'message' => "Carregado com sucesso!"
                ], 200); 
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Nenhum registro encontrado!'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Algo deu errado!'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
            if($user){
                return response()->json([
                    'data' => UserResource::collection($user),
                    'error' => false,
                    'message' => 'Encontrado com sucesso!'
                ], 200);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Não existe!'
                ], 200);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Erro ao cadastrar!'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find($request->id);
        try {
            if($user){
                $affected =     $user->update($request->all());
                if ($affected) {
                    return response()->json([
                        'affected' => $affected,
                        'data' => $user,
                        'error' => false,
                        'message' => 'Atualizado com sucesso!'
                    ], 201);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Cadastro não existe!'
                ], 201);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Erro ao cadastrar!'
            ], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = User::find($request->id);
        
            if($user){
                // $affected = DB::table('users')
                // ->where('id', $id)
                // ->update(['password' => bcrypt($request->password)]);

            $affected = User::where('id', $request->id)
            ->update(['password' => bcrypt($request->password)]);
                if ($affected) {
                    return response()->json([
                        'error' => false,
                        'message' => 'Atualizado com sucesso!',
                        'affected' => $affected
                    ], 201);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Erro ao Atualizar!'
                ], 201);
            }

    }

}
