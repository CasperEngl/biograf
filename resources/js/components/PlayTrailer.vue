<template>
  <div class="inline-block h-full w-full">
    <figure class="group relative w-full bg-black">
      <button v-if="videoKey" type="button" @click="toggle" class="absolute inset-0 z-10 w-full flex items-center justify-center text-3xl"><i class="pr-3 fa fa-2x fa-play-circle"></i> Trailer</button>
      <img :src="poster" :alt="title" class="object-cover rounded opacity-75" :class="{
        'group-hover:opacity-50': videoKey,
      }">
    </figure>
    <dialog-modal v-if="open" @close="open = false" :background="background">
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
    background: {
      type: String,
      required: false,
    },
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
