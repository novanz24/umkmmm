<script setup>
import { useForm } from '@inertiajs/vue3'
import FormError from '@/Components/FormError.vue'

const props = defineProps({ product: Object })

const form = useForm({
  product_id: props.product.id,
  qty: 1,
})

const inc = () => form.qty++
const dec = () => { if (form.qty > 1) form.qty-- }

const submit = () => {
  if (form.qty < 1) { form.errors.qty = 'Minimal 1'; return }
  form.post('/cart/items', { preserveScroll: true })
}
</script>

<template>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-2">{{ product.name }}</h1>
    <p class="mb-4">Harga: <b>Rp {{ Number(product.price).toLocaleString() }}</b></p>

    <div class="flex items-center gap-2">
      <button @click="dec" class="px-3 py-2 border rounded">-</button>
      <input type="number" min="1" required v-model.number="form.qty"
             class="w-20 text-center border rounded py-2" />
      <button @click="inc" class="px-3 py-2 border rounded">+</button>
      <button @click="submit" class="bg-black text-white px-4 py-2 rounded"
              :disabled="form.processing">Tambah ke keranjang</button>
    </div>
    <FormError :msg="form.errors.qty" />
    <p v-if="$page.props.flash?.ok" class="text-green-700 mt-3">{{ $page.props.flash.ok }}</p>
  </div>
</template>
