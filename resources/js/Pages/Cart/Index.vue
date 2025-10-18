<script setup>
const props = defineProps({
  items: { type: Array, default: () => [] },
  total: { type: Number, default: 0 },
})
</script>


<template>
  <div class="max-w-4xl mx-auto p-6">
    <h2 class="text-xl font-semibold mb-3">Keranjang</h2>

    <template v-if="props.items.length">
      <table class="w-full border">
        <thead>
          <tr class="bg-gray-50">
            <th class="p-2 text-left">Produk</th>
            <th class="p-2">Qty</th>
            <th class="p-2">Harga</th>
            <th class="p-2">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="i in props.items" :key="i.id" class="border-t">
            <td class="p-2">{{ i.name }}</td>
            <td class="p-2 text-center">{{ i.qty }}</td>
            <td class="p-2">Rp {{ Number(i.price).toLocaleString() }}</td>
            <td class="p-2 font-medium">Rp {{ Number(i.subtotal).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>

      <p class="mt-3 font-semibold">
        Total: Rp {{ Number(props.total).toLocaleString() }}
      </p>

      <a href="/checkout"
         class="inline-block mt-4 bg-black text-white px-4 py-2 rounded">
        Checkout
      </a>
    </template>

    <template v-else>
      <p class="text-gray-600">
        Keranjangmu masih kosong. <a href="/" class="text-blue-600">Lihat katalog</a>
      </p>
    </template>
  </div>
</template>
