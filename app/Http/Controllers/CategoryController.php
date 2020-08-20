<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = Category::all();

        return response()->json(['success' => true, 'payload' => $categories,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $category = $request->validate($rules, $params);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     *
     * @return Response
     */
    public function show(Category $category)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param Category $category
     *
     * @return Response
     */
    public function update(Request $request, Category $category)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     *
     * @return Response
     */
    public function destroy(Category $category)
    {

    }
}
