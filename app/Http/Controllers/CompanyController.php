<?php

namespace App\Http\Controllers;

use App\Events\Tenant\CompanyCreated;
use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cria_banco(Request $request)
    {
        try {
            $find_company = $this->company->find($request->id);
            if($find_company){
                return response()->json([
                    'error' => false,
                    'data' => $find_company,
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

    public function tenantsMigrations(Request $request)
    {
        try {
            $find_company = $this->company->find($request->id);
            if($find_company){
                $ret = Artisan::call('tenants:migrations');

                return response()->json([
                    'error' => false,
                    'ret' => $ret,
                    'message' => 'Encontrado com sucesso!'
                ], 200);  
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Cadastro não existe!'
                ], 404);  
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Algo deu errado!',
                'getMessage' => $e->getMessage()
            ], 500);
        }
    }



    public function store(Request $request)
    {
        try {
            //* cria a company na base principal
            $company = $this->company->create([
                'name' => 'Empresa X ' . Str::random(5),
                'domain' => Str::random(5) . '.meudominio.com.br',
                'db_database' => 'aaamult_tenant_' . Str::random(5),
                'db_hostname' => '127.0.0.1',
                'db_username' => 'root',
                'db_password' => 'root',
            ]);
            if($company){
                event(new CompanyCreated($company));//* evento que vai criar a base de dados da company

                return response()->json([
                    'error' => false,
                    'company' => $company,
                    'message' => 'Empresa criada com sucesso!'
                ], 200);  
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Empresa já existe!'
                ], 404);  
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Algo deu errado!',
                'getMessage' => $e->getMessage()
            ], 500);
        }
    }

    
}
