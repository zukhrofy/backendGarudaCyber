<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function getTenants()
    {
        $tenants = Tenant::all();
        return response()->json($tenants);
    }
}
