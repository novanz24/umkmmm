<script setup>
defineProps({ order: Object })
</script>

<template>
  <div class="max-w-3xl mx-auto p-6 space-y-4">
    <h1 class="text-xl font-semibold">Order #{{ order.id }}</h1>
    <div class="text-sm text-gray-600">
      {{ order.created_at }} · Status: <b class="capitalize">{{ order.status }}</b>
    </div>
    <div class="border rounded p-4">
      <h2 class="font-medium mb-2">Alamat</h2>
      <p class="whitespace-pre-line">{{ order.address_text }}</p>
    </div>
    <div class="border rounded p-4">
      <h2 class="font-medium mb-2">Item</h2>
      <table class="w-full">
        <thead>
          <tr class="text-left border-b">
            <th class="py-2">Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="i in order.items" :key="i.id" class="border-b">
            <td class="py-2">{{ i.name }}</td>
            <td>{{ i.qty }}</td>
            <td>Rp {{ Number(i.price).toLocaleString() }}</td>
            <td>Rp {{ Number(i.subtotal).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
      <div class="mt-4 text-right font-semibold">
        Total: Rp {{ Number(order.total).toLocaleString() }}
      </div>
    </div>
  </div>
</template>
