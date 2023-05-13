<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use PDO;

class SetupController extends Controller
{
    public function index()
    {
        try {
            DB::connection()->getPdo();
            $check_admin = User::where('role', 'master')->count();
            if ($check_admin  === 0) {
                return Inertia::render('setup/Admin');
            }
        } catch (\PDOException $e) {
            // database belum aktif
            if ($e->getCode() === 2002) {
                return Inertia::render('setup/index');
            }
            // database tidak ada 
            else if ($e->getCode() === 1049) {
                return Inertia::render('setup/DB');
                // return redirect(route('setup.index', ['tab' => 'DB']));
            } else {
                return Inertia::render('setup/index');
            }
        }
    }
    public function run(SetupRequest $request)
    {
        // check db connect & exist

        try {
            DB::connection()->getPdo();
            dd($request->all());
        } catch (\Exception $e) {
            return to_route('setup.index')->with('errors', 'Somthing error here');
        }
    }

    public function CreateDb()
    {
        $host = Config::get('database.connections.mysql.host');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $dbName = Config::get('database.connections.mysql.database');
        $dsn = 'mysql:host=' . $host;
        $query = "CREATE DATABASE " . $dbName;
        $pdo = new PDO($dsn, $username, $password);
        $create = $pdo->exec($query);
        if ($create) {
            Artisan::call("migrate");
        }
    }

    public function setupAdmin(SetupRequest $request)
    {
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'master'
        ];
        $user = User::create($data);
    }
}
