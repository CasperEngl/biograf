<template>
  <transition name="status" class="opacity-0">
    <div
      v-if="show"
      :style="{
        transitionDelay: '1000ms'
      }"
      class="status-box mt-2 py-4 px-5 animated inline-block text-lg rounded shadow-lg"
      :class="[internalBoxType, show ? 'visible' : 'invisible']"
    >
      <slot></slot>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    boxType: String,
    backgroundColor: String,
    textColor: String,
    timeout: {
      boxType: Number,
      default: 5000,
    },
  },
  data: (vm) => ({
    show: false,
    internalBoxType: `${vm.boxType}-box`,
    setTimeout: null,
  }),
  mounted() {
    this.show = true;

    this.setTimeout = setTimeout(() => {
      this.show = false;
    }, this.timeout);
  },
  beforeDestroy() {
    clearTimeout(this.timeout);
  },
};
</script>

<style scoped>
.status-enter {
  opacity: 0;
  transform: translateX(-30px);
}

.status-enter-active {
  transition: all 350ms cubic-bezier(.1,1.8,.85,.65);
}

.status-enter-to {
  opacity: 1;
  transform: translateX(0);
}

.status-leave {
  opacity: 1;
  transform: translateX(0);
}

.status-leave-active {
  transition: all 150ms cubic-bezier(.1,1.8,.85,.65);
}

.status-leave-to {
  opacity: 0;
  transform: translateX(-30px);
}
</style>
