<script setup>
defineProps({ links: Array })
</script>
<template>
  <nav v-if="links?.length" class="flex gap-1 mt-6 flex-wrap">
    <a v-for="(l,i) in links" :key="i"
       :href="l.url || '#'"
       v-html="l.label"
       class="px-3 py-1 rounded border"
       :class="[{ 'opacity-50 pointer-events-none': !l.url }, l.active ? 'bg-black text-white' : 'bg-white']"></a>
  </nav>
</template>
