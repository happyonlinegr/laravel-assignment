<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index():JsonResponse{
        $categories = Category::all();
        if ($categories->isEmpty()) {
            return response()->json([], 204);
        }

        return response()->json($categories, 200);
    }
}
