<?php

namespace App\Http\Controllers;

use PDF;
use App\Exports\LateExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Late;
use App\Models\Rombel;
use App\Models\Rayon;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function exportToExcel()
    {
        $file_name = 'data_keterlambatan' . '.xlsx';

        return Excel::download(new LateExport, $file_name);
    }

    public function index(Request $request)
    {
        $lates = Late::with('student');
        $query = $request->input('query');

        $lates = Late::when($query, function ($query) use ($request) {
            return $query->where('id', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('date_time_late', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('information', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('student_id', 'like', '%' . $request->input('query') . '%');
        })
        ->get();
        // $students = Student::when($query, function ($query) use ($request) {
        //     return $query->where('nis', 'like', '%' . $request->input('query') . '%')
        //                 ->orWhere('name', 'like', '%' . $request->input('query') . '%');
        // })
        // ->get();
        if (!$request->has('query')) {
            $lates = Late::all();
        }
        return view('late.admin.index', compact('lates'));
    }   
    public function data(Request $request)
    {
        // Dapatkan pengguna yang sedang masuk
        $ps = User::with('rayon')->find(Auth::id());

        // Inisialisasi query untuk data keterlambatan
        $latesQuery = Late::with('student');

        // Jika pengguna memiliki rayon
        if ($ps->rayon) {
            $rayonName = $ps->rayon->rayon;

            // Filter data keterlambatan hanya untuk siswa dengan rayon yang sesuai
            $latesQuery->whereHas('student.rayon', function ($query) use ($rayonName) {
                $query->where('rayon', $rayonName);
            });
        }

        // Handle pencarian
        $query = $request->input('query');
        if ($query) {
            $latesQuery->where('id', 'like', '%' . $query . '%')
                ->orWhere('date_time_late', 'like', '%' . $query . '%')
                ->orWhere('information', 'like', '%' . $query . '%')
                ->orWhere('student_id', 'like', '%' . $query . '%');
        }

        // Ambil data keterlambatan
        $lates = $latesQuery->get();

        // Tampilkan view
        return view('late.ps.index', compact('lates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $students = Student::all();
        return view("late.admin.create", compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'date_time_late' => 'required',
                'information' => 'required',
                'bukti' => 'required|file|mimes:jpeg,png,pdf,doc,docx',
            ]);

            // dd($request);
    
            // Ensure the student exists
            // $student = Student::where('id', $request->name)->first();
            $student = Student::where('id', $request->input('name'))->first();

            if (!$student) {
                return redirect()->back()->with('error', 'Student not found.');
            }
    
            // Get the uploaded file
            $buktiFile = $request->file('bukti');
    
            // Check if the file is valid
            if ($buktiFile->isValid()) {
                // Get the file extension
                $extension = $buktiFile->getClientOriginalExtension();
    
                // Create the Late record
                Late::create([
                    'student_id' => $student->id,
                    'date_time_late' => $request->date_time_late,
                    'information' => $request->information,
                    'bukti' => $buktiFile->storeAs('bukti', time() . '_' . $request->name . '.' . $extension, 'public')
                ]);
    
                return redirect()->route('late.admin.index')->with('success', 'Late record added successfully!');
            } else {
                // Handle the case where the file is not valid
                return redirect()->back()->withErrors(['bukti' => 'The bukti field must be a valid file.']);
            }
        } catch (\Exception $e) {
            // Log the exception for further investigation
            \Log::error($e);
    
            // Redirect back with an error message
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function rekapitulasi(Request $request)
    {
        // Gunakan Eloquent Relationship untuk mengaitkan tabel 'lates' dan 'students'
        $lates = Late::with('student');

        $query = $request->input('query');

        $lates = $lates->when($query, function ($query) use ($request) {
            return $query->where('lates.id', 'like', '%' . $request->input('query') . '%')
                        ->orWhereHas('student', function ($subquery) use ($request) {
                            $subquery->where('nis', 'like', '%' . $request->input('query') . '%')
                                ->orWhere('name', 'like', '%' . $request->input('query') . '%');
                        });
        })
        ->get();

        if (!$request->has('query')) {
            $lates = Late::all();
        }

        $lates = Late::selectRaw('lates.student_id as student_id, students.name as student_name, students.nis, COUNT(*) as total_late, MAX(lates.date_time_late) as lates_late_date')
            ->join('students', 'lates.student_id', '=', 'students.id')
            ->groupBy('student_id', 'students.name', 'students.nis')
            ->get();

        $student = Late::with('student')->simplePaginate(5);

        // Pass the $lateCounts data to the 'late.count-and-list-by-name' view
        return view('late.admin.rekap', compact('lates', 'student'));
    }

    public function rekapitulasiPs(Request $request)
    {
        // Ambil informasi pengguna yang sedang masuk (role PS)
        $ps = User::with('rayon')->find(Auth::id());

        // Inisialisasi query untuk data keterlambatan
        $latesQuery = Late::with(['student', 'student.rayon']);

        // Jika pengguna memiliki rayon
        if ($ps->rayon) {
            $rayonName = $ps->rayon->rayon;

            // Filter data keterlambatan hanya untuk siswa dengan rayon yang sesuai
            $latesQuery->whereHas('student.rayon', function ($query) use ($rayonName) {
                $query->where('rayon', $rayonName);
            });
        }

        // Handle pencarian
        $query = $request->input('query');
        if ($query) {
            $latesQuery->where('id', 'like', '%' . $query . '%')
                ->orWhere('date_time_late', 'like', '%' . $query . '%')
                ->orWhere('information', 'like', '%' . $query . '%')
                ->orWhere('student_id', 'like', '%' . $query . '%');
        }

        // Ambil data keterlambatan
        $lates = $latesQuery->get();

        // Proses data rekapitulasi hanya untuk rayon pengguna yang sedang masuk
        $rekapitulasi = Late::selectRaw('lates.student_id as student_id, students.name as student_name, students.nis, COUNT(*) as total_late, MAX(lates.date_time_late) as lates_late_date')
            ->join('students', 'lates.student_id', '=', 'students.id')
            ->when($ps->rayon, function ($query) use ($ps) {
                $query->whereHas('student.rayon', function ($query) use ($ps) {
                    $query->where('rayon', $ps->rayon->rayon);
                });
            })
            ->groupBy('student_id', 'students.name', 'students.nis')
            ->get();

        return view('late.ps.rekap', compact('rekapitulasi'));
    }


    public function print($id) 
    {
        $student = Student::find($id);
        if (!$student) {
            abort(404); // Handle the case where the student is not found
        }

        $rayon = Rayon::find($student['rayon_id']);
        $rombel = Rombel::find($student['rombel_id']);
        $ps = User::find($rayon['user_id']);

        $lates = Late::where('student_id', $id)->get();

        return view("late.admin.print", compact('lates', 'student', 'rayon', 'rombel', 'ps'));
    }
    public function printPS($id) 
    {
        $student = Student::find($id);
        if (!$student) {
            abort(404); // Handle the case where the student is not found
        }

        $rayon = Rayon::find($student['rayon_id']);
        $rombel = Rombel::find($student['rombel_id']);
        $ps = User::find($rayon['user_id']);

        $lates = Late::where('student_id', $id)->get();

        return view("late.ps.print", compact('lates', 'student', 'rayon', 'rombel', 'ps'));
    }



    public function unduhPDF($id)
    {
        $student = Student::where('id', $id)->first()->toArray();
        view()->share('student',$student);

        $rayon = Rayon::where('id', $student['rayon_id'])->first()->toArray();
        view()->share('rayon',$rayon);
        
        $rombel = Rombel::where('id', $student['rombel_id'])->first()->toArray();
        view()->share('rombel',$rombel);

        $ps = User::where('id', $rayon['user_id'])->first();
        view()->share('ps',$ps);

        $lates = Late::where('student_id', $id)->get();
        view()->share('lates', $lates);

        $pdf = PDF::loadview('late.admin.unduh', $student);
        return $pdf->download('Surat Pernyataan.pdf');
    }
    public function unduhPS($id)
    {
        $student = Student::where('id', $id)->first()->toArray();
        view()->share('student',$student);

        $rayon = Rayon::where('id', $student['rayon_id'])->first()->toArray();
        view()->share('rayon',$rayon);
        
        $rombel = Rombel::where('id', $student['rombel_id'])->first()->toArray();
        view()->share('rombel',$rombel);

        $ps = User::where('id', $rayon['user_id'])->first();
        view()->share('ps',$ps);

        $lates = Late::where('student_id', $id)->get();
        view()->share('lates', $lates);

        $pdf = PDF::loadview('late.ps.unduh', $student);
        return $pdf->download('Surat Pernyataan.pdf');
    }

    

    public function detail(Request $request, $id) 
    {
        // $student_id = $request->input('student_id'); // Gantilah ini sesuai dengan nama input pada form

        $lates = Late::where('student_id', $id)->get();

        return view('late.ps.detail', compact('lates'));
    }

    // controller
    public function detailKeterlambatan(Request $request, $id) 
    {
         // Use query method to retrieve query parameters

        $lates = Late::where('student_id', $id)->get();
        
        return view('late.admin.detail', compact('lates'));
        
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Late $late)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Late $late, $id)
    {
        $late = Late::find($id);
        $students = Student::all();
        return view('late.admin.edit', compact('late', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Late $late, $id)
{
    try {
        $request->validate([
            'name' => 'required',
            'date_time_late' => 'required',
            'information' => 'required',
            'bukti' => 'required|file|mimes:jpeg,png,pdf,doc,docx',
        ]);

        // Ensure the student exists
        // $student = Student::where('id', $request->name)->first();
        $student = Student::where('id', $request->input('name'))->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        // Get the uploaded file
        $buktiFile = $request->file('bukti');

        // Check if the file is valid
        if ($buktiFile->isValid()) {
            // Get the file extension
            $extension = $buktiFile->getClientOriginalExtension();

            // Update the Late record
            $late->update([
                'student_id' => $student->id,
                'date_time_late' => $request->date_time_late,
                'information' => $request->information,
                'bukti' => $buktiFile->storeAs('public/bukti', $request->name . '.' . $extension)
            ]);

            return redirect()->route('late.index')->with('success', 'Berhasil mengubah data!');
        } else {
            // Handle the case where the file is not valid
            return redirect()->back()->withErrors(['bukti' => 'The bukti field must be a valid file.']);
        }
    } catch (\Exception $e) {
        // Log the exception for further investigation
        \Log::error($e);

        // Redirect back with an error message
        return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Late::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }
}
