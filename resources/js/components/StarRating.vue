<template>
  <div class="w-full">
    <vue-star-rating
      v-model="rating"
      :show-rating="false"
      :star-size="30"
      border-color="rgba(0, 0, 0, 0)"
    ></vue-star-rating>
    <input type="hidden" name="rating" v-model="rating">
  </div>
</template>

<script>
export default {
  data: () => ({
    rating: 0,
  }),
};
</script>
