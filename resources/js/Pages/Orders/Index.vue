<script setup>
defineProps({ orders: Object }) // paginator
</script>

<template>
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="text-xl font-semibold mb-4">Pesanan saya</h1>

    <div v-if="orders.data.length === 0" class="text-gray-600">
      Belum ada pesanan.
    </div>

    <div v-else class="space-y-3">
      <div v-for="o in orders.data" :key="o.id" class="border rounded p-4 flex justify-between items-center">
        <div>
          <div class="font-medium">Order #{{ o.id }}</div>
          <div class="text-sm text-gray-600">
            {{ o.created_at }} · {{ o.items_count }} item · Status: <b class="capitalize">{{ o.status }}</b>
          </div>
        </div>
        <div class="text-right">
          <div class="font-semibold">Rp {{ Number(o.total).toLocaleString() }}</div>
          <a :href="`/orders/${o.id}`" class="text-blue-600">Detail</a>
        </div>
      </div>
    </div>

    <!-- pagination sederhana -->
    <div class="mt-4 flex gap-2">
      <a v-if="orders.prev_page_url" :href="orders.prev_page_url" class="px-3 py-1 border rounded">« Sebelumnya</a>
      <a v-if="orders.next_page_url" :href="orders.next_page_url" class="px-3 py-1 border rounded">Berikutnya »</a>
    </div>
  </div>
</template>
