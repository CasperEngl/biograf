<template>
  <div class="inline-block h-full w-full">
    <figure class="group relative w-full bg-gray-900">
      <button type="button" @click="toggle" class="fa fa-5x fa-play-circle absolute inset-0 z-50 w-full flex items-center justify-center"></button>
      <img :src="poster" :alt="title" class="group-hover:opacity-50 object-cover">
    </figure>
    <dialog-modal v-if="open" @close="open = false">
      <youtube-embed :video-id="videoKey" player-width="100%" player-height="100%" :player-vars="{ autoplay: 1 }" class="relative aspect-ratio aspect-ratio-16/9"></youtube-embed>
    </dialog-modal>
  </div>
</template>

<script>
export default {
  props: {
    videoKey: String,
    title: String,
    poster: String,
  },
  data: () => ({
    open: false,
  }),
  methods: {
    toggle() {
      this.open = true;
    },
  },
};
</script>

<style>
.aspect-ratio > iframe {
  position: absolute;
}
</style>
