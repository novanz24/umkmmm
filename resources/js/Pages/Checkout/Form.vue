<script setup>
import { useForm } from '@inertiajs/vue3'
import FormError from '@/Components/FormError.vue'

const props = defineProps({ total: Number })

const form = useForm({ address_text: '' })

const submit = () => {
  if (!form.address_text || form.address_text.length < 10) {
    form.errors.address_text = 'Alamat minimal 10 karakter'
    return
  }
  form.post('/checkout')
}
</script>

<template>
  <div class="max-w-xl mx-auto p-6">
    <h2 class="text-xl font-semibold mb-3">Checkout</h2>
    <p class="mb-3">Total: <b>Rp {{ Number(total).toLocaleString() }}</b></p>

    <form @submit.prevent="submit" class="space-y-3">
      <textarea v-model.trim="form.address_text" required rows="4"
                class="w-full border rounded p-2"
                placeholder="Alamat lengkap pengiriman"></textarea>
      <FormError :msg="form.errors.address_text" />
      <button class="bg-black text-white px-4 py-2 rounded" :disabled="form.processing">
        Buat Pesanan
      </button>
    </form>

    <p v-if="$page.props.flash?.ok" class="text-green-700 mt-3">{{ $page.props.flash.ok }}</p>
  </div>
</template>
