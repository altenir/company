<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Security\AuthController;
use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/get-host', function () {
    return request()->getHost(); //! obtem o host que está fazendo a chamada
});


Route::prefix('auth')->group(function()
{
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout',[AuthController::class, 'logout']);
});


Route::get('/executa-comando', function (ManagerTenant $tenant) {
    $companies = Company::all();
    foreach ($companies as $company) {
        $tenant->setConnection($company);
        $ret = Artisan::call('migrate', [
            '--force' => true,
            '--path'=> '/database/migrations/tenant',
        ]);
    }  
});
    
Route::post('/store',[CompanyController::class, 'store']);
Route::post('/tenants-migrations',[CompanyController::class, 'tenantsMigrations']);
Route::post('/troca_conexao',[CompanyController::class, 'troca_conexao']);