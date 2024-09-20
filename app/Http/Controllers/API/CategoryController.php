<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getChildren(Request $request)
    {
        $categoryId = $request->input('id');

        if (!$categoryId) {
            return response()->json(['error' => 'Category ID is required.'], 400);
        }

        $children = Category::where('parent_id', $categoryId)->get();

        if ($children->isEmpty()) {
            return response()->json(['message' => 'No children found for this category.'], 404);
        }

        return response()->json($children);
    }
}
