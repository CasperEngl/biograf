<template>
  <p>
    {{ content }}
    <a href="#" class="mt-2 block text-blue-400 no-underline hover:underline" @click.prevent="() => hidden = !hidden">Read more</a>
  </p>
</template>

<script>
const getChildrenTextContent = (children) => children.map((node) => (node.children
  ? getChildrenTextContent(node.children)
  : node.text)).join('');

export default {
  props: {
    maxLength: {
      type: Number,
      required: true,
    },
  },
  data: () => ({
    hidden: true,
  }),
  computed: {
    content() {
      const text = getChildrenTextContent(this.$slots.default);

      if (this.hidden && this.maxLength < text.length) {
        return `${text.substring(0, this.maxLength)}...`;
      }

      return text;
    },
  },
};
</script>
