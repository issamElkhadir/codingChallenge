<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortBy = $request->query('sortBy');
        $categoryId = $request->query('categoryId');
        
        $products = $this->productRepository->getProducts($sortBy , $categoryId);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $productRequest)
    {
        try {
           
            $validatedData = $productRequest->validated();

            if ($productRequest->hasFile('image')) {
                $file = $productRequest->file('image');
                $filename = uniqid() . $file->getClientOriginalName();
                $file->move(public_path('storage/products/images'), $filename);
                $validatedData['image'] = $filename;
            }

            $newProduct = $this->productRepository->create($validatedData);

            return ProductResource::make($newProduct);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
