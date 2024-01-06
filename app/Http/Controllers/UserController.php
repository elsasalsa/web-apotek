<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function loginAuth(Request $request)
    {
        //validasi
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        //ambil value dari input & simpan disebuah variable
        $users = $request->only(['email', 'password']);
        //auth::attempt -> memasukkan data user yg diinput ke fitur Auth laravel (konfirmasi proses authentication)
        if (Auth::attempt($users)) {
            //kalau akun sesuai anatara email & passwordnya, dan proses penyimoanan data ke Auth nya berhasil jalanin
            //redirect : ambik path routenya, redirect()->route() : ambil name route
            return redirect('/dashboard');
        } else {
            return redirect()->back()->with('failed', 'Email dan password tidak sesuai. Silakan coba lagi!');
        }
    }
    public function logout()
    {
        //menghapus session/data login (auth)
        Auth::logout();
        //setelah dihapus diarahkan ke
        return redirect()->route('login');
    }
    public function error()
    {
        return view('error');
    }
    
    public function index(Request $request)
    {
        //
        $users = User::orderBy('name', 'ASC');
        $query = $request->input('query');

        $users = User::when($query, function ($query) use ($request) {
            return $query->where('id', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('name', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('email', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('role', 'like', '%' . $request->input('query') . '%');
        })
        ->get();
        if (!$request->has('query')) {
            $users = User::all();
        }
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make(substr($request->email, 0, 3). substr($request->name, 0, 3))
        ]);

        return redirect()->route('user.index')->with('success', 'Berhasil menambahkan data user!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(User $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required|max:255', 
        ]);

        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => substr($request->role, 0, 255),
        ]);
        
        return redirect()->route('user.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        User::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }
}