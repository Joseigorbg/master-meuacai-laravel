<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('dashboard'); // Redireciona para o dashboard se autenticado
        } else {
            return view('guest'); // Exibe a tela de guest se não autenticado
        }
    }
}
