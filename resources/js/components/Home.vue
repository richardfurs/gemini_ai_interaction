<script setup lang="ts">
import { ref, onMounted } from 'vue'

const message = ref('')

onMounted(async () => {
  const res = await fetch(`${import.meta.env.VITE_API_URL}/test`)
  const data = await res.json()
  message.value = data.message
})
</script>

<template>
  <h1 class="text-xs">{{ message }}</h1>
</template>