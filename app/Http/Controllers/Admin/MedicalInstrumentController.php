<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalInstrument;
use App\Models\Storage;
use Illuminate\Http\Request;

class MedicalInstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = MedicalInstrument::query()->with(['suppliers', 'storage', 'unit','category'])->latest('id')->get();
        return view('admin.medicalInstrument.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.medicalInstrument.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $medicalInstrument = MedicalInstrument::findOrFail($id);//trả về 404
        return view('admin.medicalInstrument.edit',compact('medicalInstrument'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
