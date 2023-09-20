<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    protected Product $productModel ;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function getProducts ($sortBy=null , $categoryId =null)
    {
        $query = Product::query();
        if ($sortBy) {
            if($sortBy === "asc"){
                $query->orderBy('price' , 'asc');
            }elseif ($sortBy === "desc"){
                $query->orderBy('price' , 'desc');
            }else {
                $query->orderBy($sortBy);
            }
        }
    
        if ($categoryId) {
            $query->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            });
        }

        $products = $query->get();

        return $products;
    }
    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data)
    {
        $categoryIds = $data['categories'];

        $newProduct = $this->productModel->create(\Arr::except($data, 'categories'));

        $newProduct->categories()->attach($categoryIds);

        return $newProduct;
    }
}