<?php

namespace App\Http\Controllers;

use App\Http\Requests\OperatorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class operatorController extends Controller
{
    private User $user;
    public function __construct()
    {
        $this->user = new User();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->keyword) {
            $operators = $this->user->where('role', 'operator')->where("name", "LIKE", "%" . $request->keyword . "%")->orWhere("username", "LIKE", "%" . $request->keyword . "%")->get();
        } else {
            $operators = $this->user->where('role', 'operator')->get();
        }
        return Inertia::render("operator/index", ['operators' => $operators]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("operator/create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OperatorRequest $request)
    {
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'operator'
        ];

        $this->user->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $operator = $this->user->where('role', 'operator')->find($id);
        return Inertia::render('operator/edit', ['operator' => $operator]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OperatorRequest $request, string $id)
    {
        if ($request->password) {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'operator'
            ];
        } else {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'role' => 'operator'
            ];
        }

        $this->user->where('id', $id)->where('role', 'operator')->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->user->where('role', 'operator')->where('id', $id)->delete();
    }
}
