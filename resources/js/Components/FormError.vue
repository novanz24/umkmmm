<script setup>
defineProps({ msg: String })
</script>
<template>
  <p v-if="msg" class="text-sm text-red-600 mt-1">{{ msg }}</p>
</template>
