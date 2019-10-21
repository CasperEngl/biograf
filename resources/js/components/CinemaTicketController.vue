<template>
  <div class="p-10 bg-gray-800">
    <label for="ticket-count-regular" class="my-3 block">
      <h3 class="block text-white text-xl uppercase font-black mb-1">Almindelig billet</h3>
      <h4 class="mb-2">{{ $store.getters.regularPrice }} kr.</h4>
      <select name="ticket_count[regular]" id="ticket-count-regular" class="field" v-model="regularCount" @change="$store.commit('changeTicketCount', {
        type: 'regular',
        value: regularCount,
      })">
        <option value="0" disabled selected>0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
      </select>
    </label>
    <label for="ticket-count-senior" class="my-3 block">
      <h3 class="block text-white text-xl uppercase font-black mb-1">Seniorbillet</h3>
      <h4 class="mb-2">{{ $store.getters.seniorPrice }} kr.</h4>
      <select name="ticket_count[senior]" id="ticket-count-senior" class="field" v-model="seniorCount" @change="$store.commit('changeTicketCount', {
        type: 'senior',
        value: seniorCount,
      })">
        <option value="0" disabled selected>0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
      </select>
    </label>
    <hr class="my-8">
    <p class="mb-2 uppercase"><strong>I alt</strong> uden gebyrer</p>
    <h2 class="text-3xl uppercase">{{ $store.getters.ticketsPrice }} kr.</h2>
    <hr class="my-8">
    <p class="uppercase mb-2"><strong>Gebyret opkræves af den enkelte biograf</strong></p>
    <p class="uppercase mb-2">
      <strong class="block">Købsgebyr</strong>
      Afhængig af kort
    </p>
  </div>
</template>

<script>
export default {
  props: {
    price: {
      type: String,
      required: true,
    },
  },
  created() {
    this.$store.commit('changeTicketCount', {
      type: 'regular',
      value: this.regularCount,
    });

    this.$store.commit('changeTicketCount', {
      type: 'senior',
      value: this.seniorCount,
    });

    this.$store.commit('changeTicketPrice', {
      type: 'regular',
      value: Math.floor(this.price / 100 / 5) * 5,
    });

    this.$store.commit('changeTicketPrice', {
      type: 'senior',
      value: Math.floor((this.price * 0.9) / 100 / 5) * 5,
    });
  },
  data: () => ({
    regularCount: 0,
    seniorCount: 0,
  }),
};
</script>
