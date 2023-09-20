<template>
  <div class="card">
    <img
      :src="getImageUrl()"
      class="card-img-top"
      alt="Product Image"
    />
    <div class="card-body">
      <h5 class="card-title">{{ name }} </h5>
      <p class="card-text">{{ description }}</p>
      <p class="card-text">
        <strong>Price: ${{ price }}</strong>
      </p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  image : {
    type : String 
  } ,
  name : {
    type : String ,
    required :  true
  },
  description : {
    type : String ,
    required :  true
  },
  price : {
    type : Number ,
    required :  true
  },
});

const getImageUrl = () => {
  return `http://localhost:8000/storage/products/images/${props.image}`;
};

</script>