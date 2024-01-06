<?php

namespace App\Http\Controllers;

use PDF;
use App\Exports\LateExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Late;
use App\Models\Student;
use Illuminate\Http\Request;
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
        $lates = Late::with('student');
        $query = $request->input('query');

        $lates = Late::when($query, function ($query) use ($request) {
            return $query->where('id', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('date_time_late', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('information', 'like', '%' . $request->input('query') . '%')
                        ->orWhere('student_id', 'like', '%' . $request->input('query') . '%');
        })
        ->get();
    
        if (!$request->has('query')) {
            $lates = Late::all();
        }

        
        return view('late.ps.rekap', compact('lates'));
    }

    public function surat($id) 
    {
        
        return view('late.ps.surat');
    }

    public function suratPernyataan($id)
    {
        $late = Late::with('student')->where('student_id', $id)->first();

        if (!$late) {
            return response()->json(['error' => 'ID not found'], 404);
        }

        $relatedLates = Late::where('student_id', $late->student_id)->orderBy('date_time_late', 'ASC')->get();
        $students = $relatedLates->pluck('student')->unique('id')->values();

        $lateByStudent = $relatedLates->groupBy('student.id');

        view()->share('late', $relatedLates);
        view()->share('students', $students);
        view()->share('lateByStudent', $lateByStudent);

        $pdf = PDF::loadView('late.pdf', compact('relatedLates', 'students', 'lateByStudent'));

        return $pdf->download('Surat.pdf');
    }
    // public function suratPernyataan($id)
    // {
    //     // $lates = Late::where('student_id', $student_id)->get();
    //     // return view(admin.late)
    //     // $lates = Late::find($id);
    //     // if ($id) {
    //     //     return view('late.admin.surat', compact('lates'));
    //     // }   
    //     // Retrieve the total late data using a query
    //     $total_late = Late::selectRaw('lates.student_id as student_id, students.name as student_name, students.nis, COUNT(*) as total_late, MAX(lates.date_time_late) as lates_late_date')
    //         ->join('students', 'lates.student_id', '=', 'students.id')
    //         ->groupBy('student_id', 'students.name', 'students.nis')
    //         ->get();

    //     // Retrieve the individual student data
    //     $late = Student::with('rombel', 'rayon')->find($id);

    //     // Convert the individual student data to an array
        
    //     $lates = $late->toArray();
        

    //     // Share the data to the view
    //     view()->share(['total_late' => $total_late, 'lates' => $lates]);

    //     // Load the PDF view with the shared data
    //     $pdf = PDF::loadView('late.downloadPDF', ['total_late' => $total_late, 'lates' => $lates]);

    //     // Download the PDF
    //     return $pdf->download('Surat pernyataan.pdf');
    // }

    public function detail(Request $request) 
    {
        $student_id = $request->input('student_id'); // Gantilah ini sesuai dengan nama input pada form

        $lates = Late::where('student_id', $student_id)->get();

        return view('late.ps.detail', compact('lates'));
    }

    // controller
    public function detailKeterlambatan(Request $request, $id) 
    {
         // Use query method to retrieve query parameters

        $lates = Late::where('student_id', $id)->get();
        
        return view('late.admin.detail', compact('lates'));
        
    }


    public function export()
    {

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
        Late::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }
}
