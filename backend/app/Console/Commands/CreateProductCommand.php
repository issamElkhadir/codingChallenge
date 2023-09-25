<?php

namespace App\Console\Commands;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Services\CreateProductValidationService;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    protected ProductRepository $productRepository;
    protected CategoryRepository $categoryRepository;
    protected CreateProductValidationService $createProductValidationService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create';



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
    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, CreateProductValidationService $createProductValidationService)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->createProductValidationService = $createProductValidationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Enter the product name');
        $price = $this->ask('Enter the product price');
        $description = $this->ask('Enter the product description');
        $categories = $this->categoryRepository->pluckCategories();
        $selectedCategories = $this->choice('Select a category for the product', $categories, null, null, true);
        $categoryIds = $this->categoryRepository->getIdsByName($selectedCategories);

        $data = [
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'categories' => $categoryIds
        ];

        $this->createProductValidationService->validateProduct($data);

        $this->productRepository->create([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'categories' => $categoryIds, 
        ]);

        $this->info('Product created successfully!');
    }

}
