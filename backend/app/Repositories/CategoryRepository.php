<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    protected Category $categoryModel ;

    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    /**
     * Get all categories.
     *
     * @return Collection
     */
    public function getCategories()
    {
        $categories = $this->categoryModel->all();
        return $categories;
    }
}