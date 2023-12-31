<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\CreateProductValidationService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductRepository $productRepository;
    protected CreateProductValidationService $createProductValidationService;

    public function __construct(ProductRepository $productRepository, CreateProductValidationService $createProductValidationService) // Add the service as a dependency
    {
        $this->productRepository = $productRepository;
        $this->createProductValidationService = $createProductValidationService;
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
    public function store(ProductRequest $productRequest, ImageUploadService $imageUploadService)
    {
        try {
            $validatedData = $this->createProductValidationService->validateProduct($productRequest->all());

            if ($productRequest->hasFile('image')) {
                $file = $productRequest->file('image');
                $filename = $imageUploadService->upload($file, 'storage/products/images');
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
