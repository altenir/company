<?php

namespace App\Tenant\Database;

use Illuminate\Support\Facades\DB;
use App\Models\Company;

class DatabaseManager
{
    public function createdDatabase(Company $company)
    {
        return DB::statement("CREATE DATABASE {$company->db_database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    }
}
