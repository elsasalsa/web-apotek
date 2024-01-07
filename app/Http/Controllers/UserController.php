<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rayon;
use App\Models\Student;
use App\Models\Late;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function dashboard()
    {
        $name_rayon = Rayon::where('user_id', Auth::user()->id)->pluck('rayon')->first();

        $rayons = Rayon::where('user_id', Auth::user()->id)->pluck('id');
        $students = Student::whereIn('rayon_id', $rayons)->pluck('id');
        $lates = Late::whereIn('student_id', $students)
            ->whereDate('date_time_late', Carbon::today())
            ->get();
        $todayLateCount = $lates->count();
        
        $student = Student::whereIn('rayon_id', $rayons)->count();

        return view('index', compact('todayLateCount', 'student', 'name_rayon'));
    }

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
        $query = $request->input('query');
        
        $users = User::orderBy('name', 'ASC');

        if ($query) {
            $users = $users->where('id', 'like', '%' . $query . '%')
                ->orWhere('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orWhere('role', 'like', '%' . $query . '%');
        }

        $users = $users->paginate(10);

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
            'role' => 'required',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Check if a new password is provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        User::where('id', $id)->update($userData);

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