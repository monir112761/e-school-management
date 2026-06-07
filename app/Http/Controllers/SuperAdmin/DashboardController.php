<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSchools = School::count();
        $activeSchools = School::where('is_active', true)->count();
        $totalUsers = \App\Models\User::count();
        
        $recentSchools = School::latest()->take(5)->get();
        
        return view('super-admin.dashboard', [
            'totalSchools' => $totalSchools,
            'activeSchools' => $activeSchools,
            'totalUsers' => $totalUsers,
            'recentSchools' => $recentSchools,
        ]);
    }
}
