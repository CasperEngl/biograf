<template>
  <div class="p-4 row justify-center bg-gray-800">
    <div class="my-3 col flex items-center">
      <span v-html="svg('seat', 'pr-2 text-gray-700')"></span> Ledigt sæde
    </div>
    <div class="my-3 col flex items-center">
      <span v-html="svg('seat', 'pr-2 text-red-600')"></span> Optaget sæde
    </div>
    <div class="my-3 col flex items-center">
      <span v-html="svg('seat', 'pr-2 text-blue-500')"></span> Kørestolsplads
    </div>
    <div class="my-3 col flex items-center">
      <span v-html="svg('seat', 'pr-2 text-green-600')"></span> Dine pladser
    </div>
  </div>
</template>
