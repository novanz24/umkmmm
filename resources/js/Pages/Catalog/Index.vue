<script setup>
import { router, Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  products: Object,          // paginator
  categories: Array,
  filters: Object
})

const submit = (e) => {
  const params = new URLSearchParams(new FormData(e.target))
  router.get('/', Object.fromEntries(params), { preserveScroll: true, preserveState: true })
}
</script>

<template>
  <div class="max-w-6xl mx-auto p-6">
    <form @submit.prevent="submit" class="flex gap-2 mb-4">
      <input class="border rounded px-3 py-2" name="q" :value="filters?.q" placeholder="Cari produk..." />
      <select class="border rounded px-3 py-2" name="category_id" :value="filters?.category_id">
        <option value="">Semua kategori</option>
        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
      </select>
      <button class="bg-black text-white px-4 rounded">Cari</button>
    </form>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="p in products.data" :key="p.id" class="border rounded p-4">
        <h3 class="font-semibold mb-1">{{ p.name }}</h3>
        <p class="text-sm text-gray-600">Rp {{ Number(p.price).toLocaleString() }}</p>
        <Link :href="`/products/${p.id}`" class="text-blue-600 mt-2 inline-block">Detail</Link>
      </div>
    </div>

    <Pagination :links="products.links" />
  </div>
</template>
