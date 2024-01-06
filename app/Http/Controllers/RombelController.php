<?php

namespace App\Http\Controllers;

use App\Models\Rombel;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rombels = Rombel::with('user');
        $query = $request->input('query');

        $rombels = Rombel::when($query, function ($query) use ($request) {
            return $query->orWhere('rombel', 'like', '%' . $request->input('query') . '%');
        })
        ->get();
        if (!$request->has('query')) {
            $rombels = Rombel::all();
        }
        return view('rombel.index', compact('rombels'));

        // $keyword = $request->input('search');
        // $rombels = $keyword ? Rombel::search($keyword) : Rombel::all();
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rombel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rombel' => 'required',
            
        ]);

        Rombel::create([
            'rombel' => $request->rombel,
            // 'password' => Hash::make(substr($request->rombel, 0, 3). substr($request->name, 0, 3))
        ]);

        return redirect()->route('rombel.index')->with('success', 'Berhasil menambahkan data user!');
    }

    /**
     * Display the specified resource.
     */
    public function show(rombel $rombel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rombel $rombel, $id)
    {
        $rombel = Rombel::find($id);
        return view('rombel.edit', compact('rombel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, rombel $rombel, $id)
    {
        $request->validate([
            'rombel' => 'required',
        ]);

       
        Rombel::where('id', $id)->update([
            'rombel' => $request->rombel,
        ]);
    
        return redirect()->route('rombel.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rombel $rombel, $id)
    {
        Rombel::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data !');
    }
}
