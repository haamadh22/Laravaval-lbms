<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User; 

class MemberController extends Controller
{
        public function dashboard()
        {
            return auth()->user()->role === 'admin'
                ? view('admin.dashboard')
                : view('user.dashboard');
        }       
}
