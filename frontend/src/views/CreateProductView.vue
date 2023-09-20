<template>
  <div class="container mt-5 p-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
          <button class="btn btn-outline-primary mb-2" @click="goBack">Go Back</button>
            <h1 class="mb-4">Create Product</h1>
            <form @submit.prevent="submitForm" enctype="multipart/form-data" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span> </label>
                    <input v-model="formData.name" type="text" class="form-control" id="name" name="name" >
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea v-model="formData.description" class="form-control" id="description" name="description" rows="4" ></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" v-model="formData.price" class="form-control" id="price" name="price" >
                </div>
                <div class="mb-3">
                  <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                  <select
                    id="categoryFilter"
                    @change="handleCategoryChange"
                    class="form-select"
                  >
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </select>
                  <div>
                    <p class="mt-2">Selected Categories:</p>
                    <div class="d-flex flex-column" v-for="(category, index) in selectedCategories" :key="index">
                      <p class="text-muted">{{ category }}</p>
                    </div>
                    <button v-if="selectedCategories.length > 0" @click="resetCategorySelection" class="btn btn-danger mt-2">Reset Selection</button>
                  </div>
                  
                </div>
                <div class="mb-3">
                  <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" @change="handleImageChange" class="form-control" id="image" name="image" accept="image/*" >
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Product</button>
            </form>
        </div>
    </div>
</div>

</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useApiGetResource } from "../hooks/useApiGetResource.js";
import { useToast } from "vue-toast-notification";
import { useApiSave} from "../hooks/useApiSave.js";
import {useRouter} from 'vue-router';

const router = useRouter();

const goBack = () => {
  router.push({name : 'home'})
}

const categories = ref([])
const formData = ref({
  name: '',
  description: '',
  price: '',
  image: null,
  selectedCategories: [],
})

const {
  load: loadCategories,
  error: errorCategories,
} = useApiGetResource("http://localhost:8000/api/categories");

const {
  save,
  error 
} = useApiSave("http://localhost:8000/api/products");

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

const toast = useToast();

onMounted(() => {
  getCategories();
});

const submitForm = () => {
  if (!formData.value.name || !formData.value.description || !formData.value.price || !formData.value.selectedCategories.length > 0 ) {
    toast.error("Please fill in all required fields.", { position: "bottom-right" });
    return;
  }

  const productData = new FormData();
  productData.append("name", formData.value.name);
  productData.append("description", formData.value.description);
  productData.append("price", formData.value.price);
  productData.append("image", formData.value.image);

  for (const categoryId of formData.value.selectedCategories) {
    productData.append("categories[]", categoryId);
  }

  save(productData, {
    onSuccess: ({ data }) => {
      toast.success('Product created successfully', { position: "bottom-right" });
      formData.value.name = ''
      formData.value.description = ''
      formData.value.price = ''
      formData.value.selectedCategories =[]
      formData.value.image =''
    },
    onError: () => {
      toast.error(error && 'Product cannot be created', { position: "bottom-right" });
    },
  });
};


const handleCategoryChange = (e) => {
  formData.value.selectedCategories.push(Number(e.target.value))
}
const handleImageChange = (event) => {
  const selectedFile = event.target.files[0];
  if (selectedFile) {
    formData.value.image = selectedFile;
  }
};


const selectedCategories = computed(() => {
  const selectedCategoriesNamesArray = [];
  
  for (const selectedCategoryId of formData.value.selectedCategories) {
    const selectedCategory = categories.value.find(category => category.id === selectedCategoryId);
    if (selectedCategory && !selectedCategoriesNamesArray.includes(selectedCategory.name)) {
      selectedCategoriesNamesArray.push(selectedCategory.name);
    }
  }
  
  return selectedCategoriesNamesArray;
});



const resetCategorySelection = () => {
  formData.value.selectedCategories = [];
};
</script>