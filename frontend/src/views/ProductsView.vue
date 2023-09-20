<template>
    <div class="container mt-5">

      <Spinner v-if="loadingProducts"/>

      <div class="row">
        <div class="col-md-12">
          <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-4">Product List</h1>
            <router-link to="/create" class="btn btn-primary"
              >Add new product</router-link
            >
          </div>
  
          <!-- Filtering and Sorting Options -->
          <div class="flex justify-between mt-4">
            <div class="mb-4">
              <label for="categoryFilter" class="block text-gray-700"
                >Filter by Category:</label
              >
              <select
                id="categoryFilter"
                v-model="selectedCategory"
                @change="getProducts"
                class="form-select"
              >
                <option value="">All Categories</option>
                <option
                  v-for="category in categories"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.name }}
                </option>
              </select>
            </div>
  
            <div class="mb-4">
              <label for="priceSort" class="block text-gray-700">Sort by Price:</label>
              <select
                id="priceSort"
                v-model="selectedSort"
                @change="getProducts"
                class="form-select"
              >
                <option value="asc">Lowest to Highest</option>
                <option value="desc">Highest to Lowest</option>
                <option value="name">name</option>
              </select>
            </div>
          </div>
  
          <!-- Product Cards -->
          <div class="row">
            <div
              class="col-md-3 mb-4"
              v-for="product in products"
              :key="product.id"
            >
              <Product
                :image="product.image"
                :name="product.name"
                :description="product.description"
                :price="product.price"
              />
            </div>
            <p v-if="products.length == 0" class="text-muted">no product yet !</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from "vue";
  import Product from "../components/Product.vue";
  import { useApiGetResource } from "../hooks/useApiGetResource.js";
  import { useToast } from "vue-toast-notification";
  import Spinner from "../components/Spinner.vue";
  
  const toast = useToast();
  const products = ref([]);
  const categories = ref([]);
  const selectedCategory = ref("");
  const selectedSort = ref("asc");
  
  const {
    load: loadCategories,
    error: errorCategories,
  } = useApiGetResource("http://localhost:8000/api/categories");
  
  const {
    load: loadProducts,
    loading: loadingProducts,
    error: errorProducts,
  } = useApiGetResource("http://localhost:8000/api/products");
  
  const getCategories = () => {
    loadCategories(undefined, {
      onSuccess: ({ data }) => {
        categories.value = data;
      },
      onError: () => {
        toast.error(errorCategories  && 'Something went wrong', { position: "bottom-right" });
      },
    });
  }
  const getProducts = () => {
    loadProducts({
        'sortBy' : selectedSort.value,
        'categoryId' : selectedCategory.value, 
    }, {
      onSuccess: ({ data }) => {
        products.value = data;
      },
      onError: () => {
        toast.error(errorProducts && 'Something went wrong', { position: "bottom-right" });
      },
    });
  };
  onMounted(() => {
    getCategories();
    getProducts();
   });
</script>
  