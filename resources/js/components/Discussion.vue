<template>
  <div>
		<div class="flex flex-row-reverse">
			<div class="rounded-xl bg-neutral-700 max-w-[75%] break-words p-2 mb-4">{{ question }}</div>
		</div>
		<div class="break-words mb-8">{{ answer }}</div>
	</div>
</template>

<script setup lang="ts">

defineProps<{
  question: string
  answer: string
}>();

</script>