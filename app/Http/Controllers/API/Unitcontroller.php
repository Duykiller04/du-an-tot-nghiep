<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class Unitcontroller extends Controller
{
    public function getChildren(Request $request)
    {
        $unitId = $request->input('id');

        if (!$unitId) {
            return response()->json(['error' => 'Unit ID is required.'], 400);
        }

        $children = Unit::where('parent_id', $unitId)->get();

        if ($children->isEmpty()) {
            return response()->json(['message' => 'No children found for this category.'], 404);
        }

        return response()->json($children);
    }
}
