<template>
  <default-field :field="field" :errors="errors" :full-width-content="true">
    <template slot="field">
      <!-- <input
        :id="field.name"
        type="text"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.name"
        :value="JSON.parse(value).map(v => `${v.row}-${v.column}`).join(', ')"
      /> -->
      <cinema-layout :cinema-seats="value" @updatedSeats="handleChange"></cinema-layout>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data: (vm) => ({
    value: JSON.stringify(vm.field.value),
  }),

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = JSON.stringify(this.field.value);
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || '');
    },

    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      this.value = JSON.stringify(value);
    },
  },
};
</script>
