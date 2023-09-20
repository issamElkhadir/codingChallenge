<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Repositories\ProductRepository;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    protected ProductRepository $productRepository;
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
    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
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

        $categories = Category::pluck('name', 'id')->toArray();
        $selectedCategories = $this->choice('Select categories for the product (comma-separated):', $categories, null, null, true);
        $categoryIds = Category::whereIn('name', $selectedCategories)->pluck('id')->toArray();

        $this->productRepository->create([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'categories' => $categoryIds, 
        ]);

        $this->info('Product created successfully!');
    }

}
