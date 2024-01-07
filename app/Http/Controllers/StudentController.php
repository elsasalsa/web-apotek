<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Rombel;
use App\Models\Rayon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Student::with('rombel', 'rayon');
        $query = $request->input('query');

        $students = Student::when($query, function ($query) use ($request) {
            return $query->where('id', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('nis', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('name', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('rombel_id', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('rayon_id', 'like', '%' . $request->input('query') . '%');
        })
        ->get();
        if (!$request->has('query')) {
            $students = Student::all();
        }
        return view('student.admin.index', compact('students'));
    }
    // public function data(Request $request)
    // {
        
    //     $students = Student::with('rombel', 'rayon');
    //     $query = $request->input('query');

    //     $students = Student::when($query, function ($query) use ($request) {
    //         return $query->where('id', 'like', '%' . $request->input('query') . '%')
    //                     ->orWhere('nis', 'like', '%' . $request->input('query') . '%')
    //                     ->orWhere('name', 'like', '%' . $request->input('query') . '%')
    //                     ->orWhere('rombel_id', 'like', '%' . $request->input('query') . '%')
    //                     ->orWhere('rayon_id', 'like', '%' . $request->input('query') . '%');
    //     })
    //     ->get();
    //     if (!$request->has('query')) {
    //         $students = Student::all();
    //     }
    //     return view('student.ps.data', compact('students'));
    // }

    public function data()
    {
        $ps = User::with('rayon')->find(Auth::id());

        if ($ps->rayon) {
            $rayonName = $ps->rayon->rayon;

            // Get students based on the rayon of the logged-in PS
            $students = Student::with('rombel', 'rayon')
                ->whereHas('rayon', function ($query) use ($rayonName) {
                    $query->where('rayon', $rayonName);
                })
                ->get();

            return view('student.ps.data', compact('students'));
            } else {
                // If PS doesn't have a rayon, show all students
                $students = Student::with('rombel', 'rayon')->get();
                return view('student.ps.data', compact('students'));
            }
        

    // ...
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rombels = Rombel::orderBy('rombel')->get();
        $rayons = Rayon::orderBy('rayon')->get();

        return view('student.admin.create', compact('rombels', 'rayons'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|min:3',
            'name' => 'required',
            'rombel' => 'required',
            'rayon' => 'required',
        ]);

        $rayons = Rayon::where('rayon', $request->rayon)->first();
        $rombels = Rombel::where('rombel', $request->rombel)->first();

        Student::create([
            'nis' => $request->nis,
            'name' => $request->name,
            'rombel_id' => $rombels->id,
            'rayon_id' => $rayons->id,
        ]);
        

        return redirect()->back()->with('success', 'Berhasil menambahkan data siswa!');
    }

    /**
     * Display the specified resource.
     */
    public function show(student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student, $id)
    {
        $student = Student::find($id);
        $rombels = Rombel::orderBy('rombel')->get();
        $rayons = Rayon::orderBy('rayon')->get();

        return view('student.admin.edit', compact('student', 'rombels', 'rayons'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student $student, $id)
    {
        $request->validate([
            'nis' => 'required|min:3',
            'name' => 'required',
            'rombel' => 'required',
            'rayon' => 'required',
        ]);

        $rayons = Rayon::where('rayon', $request->rayon)->first();
        $rombels = Rombel::where('rombel', $request->rombel)->first();

        Student::where('id', $id)->update([
            'nis' => $request->nis,
            'name' => $request->name,
            'rombel_id' => $rombels->id,
            'rayon_id' => $rayons->id,
        ]);
    
        return redirect()->route('admin.student.index', compact( 'rombels', 'rayons'))->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Student::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }
}
