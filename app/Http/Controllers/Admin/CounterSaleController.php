<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CutDosePrescription;
use App\Models\Disease;
use Illuminate\Http\Request;

class CounterSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $cutDosePrescription = CutDosePrescription::query()->with(['disease', 'cutDosePrescriptionDetails'])->get();
        // dd($cutDosePrescription->toArray());
        $disisease = Disease::select('id', 'disease_name')->get();
        return view('admin.sell.index', compact('disisease', 'cutDosePrescription', 'categories'));
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
        //
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
