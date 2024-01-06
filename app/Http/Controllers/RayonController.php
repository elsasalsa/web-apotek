<?php

namespace App\Http\Controllers;

use App\Models\Rayon;
use App\Models\User;
use Illuminate\Http\Request;

class RayonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $rayon = Rayon::orderBy('rayon', 'ASC')->simplePaginate(10);
        $rayon = Rayon::with('user');
        $query = $request->input('query');

        $rayon = Rayon::when($query, function ($query) use ($request) {
            return $query->orWhere('rayon', 'like', '%' . $request->input('query') . '%');
        })
        ->get();
        if (!$request->has('query')) {
            $rayon = Rayon::with('user')->get();
        }
        
        
        return view('rayon.index', compact('rayon',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rayon = User::where('role', 'ps')->get();
        return view('rayon.create', compact('rayon'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rayon' => 'required',
            'name' => 'required',
        ]);
    
        $users = User::where('name', $request->name)->first();

        Rayon::create([
            'rayon' => $request->rayon,
            'user_id' => $users->id,
        ]);
    
        return redirect()->back()->with('success', 'Berhasil menambahkan data!');
    }

    /**
     * Display the specified resource.
     */
    public function show(rayon $rayon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rayon $rayon, $id)
    {
        $rayon = Rayon::find($id);
        $rayons = User::where('role', 'ps')->get();
        return view('rayon.edit', compact('rayon', 'rayons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rayon $rayon, $id)
    {
        $request->validate([
            'rayon' => 'required',
            'name' => 'required',
        ]);

        $users = User::where('name', $request->name)->first();

        Rayon::where('id', $id)->update([
            'rayon' => $request->rayon,
            'user_id' => $users->id,
        ]);
    
        return redirect()->route('rayon.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rayon $rayon, $id)
    {
        Rayon::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }

}
