<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]); 

        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password'=> Hash::make($data['password']),
            'role'=> $data['role'],
        ]);

        return redirect()->back()->with('success','Berhasil Membuat User');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required', 
            'email' => 'required',
            'password' => 'nullable',
            'role' => 'required',
        ]);

        if ($request->input('password')) {
            $user->update([
                'name' => $request->input('name'),
                'email'=> $request->input('email'),
                'password'=> Hash::make($request->input('password')),
                'role'=> $request->input('role'),
            ]);
        } else {
            $user->update([
                'name'=> $request->input('name'),
                'email'=> $request->input('email'),
                'role' => $request->input('role'),
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil Mengupdate Data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus User');
    }
}
