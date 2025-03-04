<template>
  <div>
    <textarea class="block w-full" v-model="queryVal" type="text" />
    <button @click="sendQuery()">Ask</button>
  </div>
</template>

<script setup lang="ts">

import { ref, onMounted } from 'vue';

let queryVal = ref('');

const sendQuery = async () => {
  try {
    const response = await fetch(`${import.meta.env.VITE_API_URL}/ask`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        query: queryVal.value,
      }),
    })

    const data = await response.json()

    alert(`Response: ${JSON.stringify(data)}`)
  } catch (error) {
    console.error('Error:', error)
    alert('Failed to send data')
  }
}

</script>