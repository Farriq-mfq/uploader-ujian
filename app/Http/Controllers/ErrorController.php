<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ErrorController extends Controller
{
    public function index()
    {
        return Inertia::render('error/index');
    }
    public function block()
    {
        return Inertia::render('error/block', ['ip' => gethostbyname(gethostname())]);
    }
}
