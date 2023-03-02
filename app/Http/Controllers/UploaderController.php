<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UploaderController extends Controller
{
    public function index()
    {
        return Inertia::render('uploader/index');
    }

    public function upload(Request $request)
    {
        dd($request->file);
    }
}
