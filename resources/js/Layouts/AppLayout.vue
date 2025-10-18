<!-- resources/js/Layouts/AppLayout.vue -->
<script setup>
import { Link, router } from '@inertiajs/vue3'

// logout
const logout = () => router.post('/logout')
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <header class="border-b bg-white">
      <div class="max-w-6xl mx-auto p-4 flex items-center gap-4">
        <Link href="/" class="font-semibold">UMKM Mini</Link>

        <nav class="ml-auto flex items-center gap-4 text-sm">
          <Link href="/" class="hover:underline">Katalog</Link>

          <!-- Tampil hanya saat login -->
          <template v-if="$page.props.auth?.user">
            <Link href="/cart" class="hover:underline">Keranjang</Link>
            <Link href="/orders" class="hover:underline">Pesanan saya</Link>
          </template>

          <!-- Auth links -->
          <template v-if="!$page.props.auth?.user">
            <Link href="/login" class="hover:underline">Log in</Link>
            <Link href="/register" class="hover:underline">Register</Link>
          </template>
          <template v-else>
            <span class="text-gray-600">
              Hi, {{ $page.props.auth.user.name }}
            </span>
            <button @click="logout" class="px-3 py-1 border rounded">
              Logout
            </button>
          </template>
        </nav>
      </div>
    </header>

    <div
      v-if="$page.props.flash?.ok"
      class="max-w-6xl mx-auto mt-4 px-4"
    >
      <div class="rounded border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm">
        {{ $page.props.flash.ok }}
      </div>
    </div>

    <!-- MAIN -->
    <main class="max-w-6xl mx-auto p-4">
      <slot />
    </main>
  </div>
</template>
