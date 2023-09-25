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

    public function pluckCategories()
    {
        return Category::pluck('name', 'id')->toArray();
    }

    public function getIdsByName(array $categoryNames)
    {
        return Category::whereIn('name', $categoryNames)->pluck('id')->toArray();
    }
}