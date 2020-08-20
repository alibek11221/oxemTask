<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductsIndexRequest;
use App\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductsIndexRequest $request
     *
     * @return JsonResponse
     */
    public function index(ProductsIndexRequest $request): JsonResponse
    {
        $orderby = $request->input('orderby', 'price');
        $direction = $request->input('direction', 'DESC');
        $products = Product::orderBy($orderby, $direction)->paginate(50);

        return response()->json(['success' => true, 'payload' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $product = new Product(
                [
                    'name'        => $request->input('name'),
                    'description' => $request->input('description'),
                    'price'       => $request->input('price'),
                    'quantity'    => $request->input('quantity'),
                    'external_id' => $request->input('external_id'),
                ]
            );
            $product->save();
            $categories = $request->input('category_id') ?? [];
            $product->categories()->sync($categories);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        return response()->json(
            [
                'success' => true,
                'payload' => $product->id,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function show(Product $product): ?JsonResponse
    {
        try {
            $product = Product::findOrFail($product);

            return response()->json(['success' => true, 'payload' => $product], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'error' => 'Продукт не найден'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product        $product
     *
     * @return JsonResponse
     */
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        DB::beginTransaction();
        try {
            $updated = $product->fill($request->except('categroy_id'))->save();
            $categories = $request->input('category_id') ?? [];
            $updated->categories()->sync($categories);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'payload' => $updated], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function destroy(Product $product): ?JsonResponse
    {
        DB::beginTransaction();
        try {
            $product->categories()->detach();
            $product->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'payload' => []], 204);
    }
}
