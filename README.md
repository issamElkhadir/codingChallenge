# Product Manager Application

## Key Features

- **Effortless Product Management:**
  - Easily create new product listings with essential details like names, descriptions, pricing, and images.
  - Assign products to one or multiple categories.
  - Seamlessly manage your product catalog through the user-friendly web interface.
  - Alternatively, use the command-line interface for quick product additions.

- **Product Catalog Display:**
  - Effortlessly explore your product catalog.
  - Sort products by price in either ascending or descending order.
  - Streamline your search with category-based filters.

## Technologies Utilized

Our application leverages the power of modern technologies:

- **Backend Stack:**
  - Laravel 8.83.27
  - PHP 7.4.33
  - MySQL 8.0.32

- **Frontend Framework:**
  - Vue.js 3 Composition API

## Getting Started

### Prerequisites

Ensure you have the following software installed:

- Node.js v18.16.0
- Composer 2.6.3
- PHP 7.4.33
- MySQL 8.0.32

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/issamElkhadir/codingChallenge.git
2. Navigate to the backend directory:
   ```bash
   cd codingChallenge/backend
3. Install PHP dependencies using Composer:
   ```bash
   composer install
5. Configure your environment variables:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=your_database_server_port
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

6. Run database migrations to set up the database:
   ```bash
   php artisan migrate
   php artisan db:seed
7. Start the Laravel development server:
   ```bash
   php artisan serve
   php artisan storage:link


The backend should now be accessible at http://localhost:8000.

7. Navigate to the frontend directory:
   ```bash
   cd codingChallenge/frontend
8. Install JavaScript dependencies using npm:
   ```bash
    npm install
9. Build the frontend assets:
   ```bash
    npm run build
9. Start the Vue.js development server:
   ```bash
   npm run dev
The frontend should now be accessible at http://localhost:5173.

## Command-Line Product Creation
- To add a new product via the command line, use the following command:
   ```bash
   php artisan product:create {name} {price} {description?}
   
## Routes :
- Visit the product listing page at / to view and manage your products.
- To create a new product, go to /create in your web browser.


## Testing 

- Automated tests are included to cover product creation. You can run the tests for the backend using the   following command:
   ```bash
   cd backend
1. Create a product:
   ```bash
   php artisan test --filter ProductControllerTest::it_can_create_product
2. Get products:
   ```bash
   php artisan test --filter ProductControllerTest::it_can_get_products
3. Get categories:
   ```bash
   php artisan test --filter ProductControllerTest::it_can_get_categories
