<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     public function index()
    {
        return response()->json(User::select('id', 'name', 'email', 'created_at')->get());
    }
}
