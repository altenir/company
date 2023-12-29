<?php

namespace App\Http\Controllers\Security;

use App\Http\Resources\Security\AclGroupResource;
use App\Models\Security\AclGroup;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AclGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $acl_groups = AclGroup::paginate(100);
            if ($acl_groups->count() > 0) {
                return response()->json([
                    'error' => false,
                    'total' => $acl_groups->total(),
                    'perPage' => $acl_groups->perPage(),
                    'listed' => AclGroupResource::collection($acl_groups->items()),
                    'message' => "Carregado com sucesso! "
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $acl_group = AclGroup::where('description', $request->description)
            ->doesntExist();
            if($acl_group){
                $created = AclGroup::create($request->all());
                if ($created) {
                    return response()->json([
                        'error' => false,
                        'created' => new AclGroupResource($created),
                        'message' => 'Cadastrado com sucesso!'
                    ], 201); 
                } else {
                    return response()->json([
                        'error' => true,
                        'created' => false,
                        'message' => 'Cadastro não foi inclído!'
                    ], 404);
                }              
            } else {
                return response()->json([
                    'error' => true,
                    'created' => false,
                    'message' => 'Cadastro já existe!'
                ], 302);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'created' => false,
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
    public function show(Request $request, $id)
    {
        try {
            $acl_group = AclGroup::find($id);
            if($acl_group){
                return response()->json([
                    'error' => false,
                    'data' => new AclGroupResource($acl_group),
                    'message' => 'Encontrado com sucesso!'
                ], 302);  
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Cadastro não existe!'
                ], 404);  
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Algo deu errado!'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $acl_group = AclGroup::find($id);
        try {
            if($acl_group){
                $updated = $acl_group->update($request->all());
                if ($updated) {
                    return response()->json([
                        'error' => false,
                        'updated' => new AclGroupResource($acl_group),
                        'message' => 'Atualizado com sucesso!'
                    ], 201);
                } else {
                    return response()->json([
                        'error' => true,
                        'updated' => false,
                        'message' => 'Cadastro não foi atualizado!'
                    ], 404);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'updated' => false,
                    'message' => 'Cadastro não existe!'
                ], 404);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => true,
                'updated' => false,
                'message' => 'Algo deu errado!'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $acl_group = AclGroup::OfCompany($request->company_id)->find($id);
            if($acl_group) {
                $deleted = AclGroup::destroy($id);
                if($deleted) {
                    return response()->json([
                        'error' => false,
                        'data' => new AclGroupResource($acl_group),
                        'message' => ' Excluído com sucesso!'
                    ], 201);
                } else {
                    return response()->json([
                        'error' => true,
                        'message' => 'Cadastro não foi excluído!'
                    ], 404);
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
                'message' => 'Algo deu errado!'
            ], 404);
        }
    }
}
