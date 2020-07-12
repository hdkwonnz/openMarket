<?php

namespace App\Http\Controllers\Admin;

use App\Categorya;
use App\Categoryb;
use App\Categoryc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/admin/index');
    }

    public function showCategoryForm()
    {
        return view('admin.category.showCategoryForm');
    }

    public function getAllcategories(Request $request)
    {
        $categoryAs = Categorya::all();

        return response()->json([
            'categoryAs' => $categoryAs,
        ]);
    }

    public function getCategoryAbyId(Request $request)
    {
        $categoryA = Categorya::with('categorybs','categorycs')
                                ->where('id','=',$request->aId)
                                ->first();

        return response()->json([
            'categoryA' => $categoryA,
        ]);
    }

    public function getCategoryBbyId(Request $request)
    {
        $categoryB = Categoryb::with('categorya','categorycs')
                                ->where('id','=',$request->bId)
                                ->first();

        return response()->json([
            'categoryB' => $categoryB,
        ]);
    }

    public function getCategoryCbyId(Request $request)
    {
        $categoryC = Categoryc::with('categorya','categoryb')
                                ->where('id','=',$request->cId)
                                ->first();

        return response()->json([
            'categoryC' => $categoryC,
        ]);
    }
}
