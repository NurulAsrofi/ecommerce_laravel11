<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

class ListController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari model Admin dan User
        $admins = Admin::all();
        $users = User::all();

        // Mengembalikan data ke view 'welcome'
        return view('welcome', compact('admins', 'users'));
    }
}
