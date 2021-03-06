<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show', 'showProducts']);
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
     * @param CategoryRequest $request
     *
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $category = new Category(
            ['name' => $request->name, 'parent_id' => $request->parent, 'external_id' => $request->external]
        );
        $category->save();
        return response()->json(
            [
                'success' => true,
                'payload' => $category->id,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        try {
            $category = Category::findOrFail($category);

            return response()->json(['success' => true, 'payload' => $category], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'error' => 'Категория не найдена'], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function showProducts(Category $category): JsonResponse
    {
        try {
            $products = $category->products()->get();

            return response()->json(['success' => true, 'payload' => $products], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'error' => 'Данные не обнаружены'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function update(Request $request, Category $category): ?JsonResponse
    {
        $updated = $category->fill($request->all())->save();

        if ($updated) {
            return response()->json(['success' => true, 'payload' => $updated], 204);
        }

        return response()->json(['success' => false, 'error' => 'Ошибка'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function destroy(Category $category): ?JsonResponse
    {
        try {
            $category->delete();

            return response()->json(['success' => true, 'payload' => []], 204);
        } catch (Exception $exception) {
            return response()->json(
                ['success' => false, 'error' => 'Во время выполнения запроса произошла ошибка'],
                400
            );
        }
    }
}
