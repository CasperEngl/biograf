<template>
  <portal to="modal">
    <div class="p-5 md:p-12 fixed inset-y-0 z-50 shadow w-full flex justify-center items-center" @keyup.esc="close">
      <div
        role="dialog"
        class="bg-gray-900 w-full max-w-6xl"
        v-click-outside="close"
      >
        <header class="flex items-center text-gray-900 text-2xl md:text-3xl px-5" :class="[hasHeaderSlot ? 'justify-between' : 'justify-end']">
          <slot name="header"></slot>
          <button @click="close" class="text-3xl text-gray-400 py-5"><i class="fa fa-times"></i></button>
        </header>
        <slot></slot>
      </div>
    </div>
    <div class="bg-gray-700 opacity-75 fixed inset-0 z-10"></div>
  </portal>
</template>

<script>
export default {
  props: {
    hideHeading: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  created() {
    window.addEventListener('keyup', (e) => {
      if (e.key === 'Escape') this.close();
    });
  },
  methods: {
    close() {
      this.$emit('close');
    },
  },
  computed: {
    hasHeaderSlot() {
      return Boolean(this.$slots.header);
    },
  },
};
</script>
