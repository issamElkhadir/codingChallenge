<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    protected ProductRepository $productRepository;
    protected CategoryRepository $categoryRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create {name} {price} {description?}';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $price = $this->argument('price');
        $description = $this->argument('description') ?? '';
        

        if (!is_numeric($price)) {
            $this->error('Price must be a numeric value.');
            return 1;
        }

        $categories = $this->categoryRepository->pluckCategories();
        $selectedCategories = $this->choice('Select a category for the product', $categories, null, null, true);
        $categoryIds = $this->categoryRepository->getIdsByName($selectedCategories);

        $this->productRepository->create([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'categories' => $categoryIds, 
        ]);

        $this->info('Product created successfully!');
    }

}
