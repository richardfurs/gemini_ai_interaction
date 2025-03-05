<template>
  <div class="px-5 py-10 flex flex-col justify-between h-screen bg-neutral-800 text-[0.8rem] sm:text-[1.2rem] sm:px-16 lg:px-32 xl:px-64 2xl:px-100">

    <div ref="discussionRef" class="h-full text-white overflow-y-auto" :class="loading ? 'blur-xs' : ''">
      <div v-for="({question, answer}, idx) in discussionArr" :key="idx">
        <Discussion :question="question" :answer="answer" />
      </div>
    </div>

    <div>
      <div v-if="error" class="rounded-xl bg-amber-700 text-white p-2 mb-3 break-words text-center">
          {{ error.message }}
      </div>

      <div class="block bg-neutral-700 text-white p-2 flex flex-col rounded-xl">
        <textarea ref="textareaRef" @input="adjustHeight" placeholder="Ask anything" class="block w-full break-words resize-none focus:outline-none focus:ring-0" v-model="queryVal" />
        <div class="flex flex-row-reverse mt-1">
          <button @click="sendQuery">
            <div class="bg-white p-2 inline-block rounded-full">
              <svg width="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 115.4 122.88">
                <title>up-arrow</title><path d="M24.94,67.88A14.66,14.66,0,0,1,4.38,47L47.83,4.21a14.66,14.66,0,0,1,20.56,0L111,46.15A14.66,14.66,0,0,1,90.46,67.06l-18-17.69-.29,59.17c-.1,19.28-29.42,19-29.33-.25L43.14,50,24.94,67.88Z"/>
              </svg>
            </div>
          </button>
        </div>
      </div>

      <span v-if="loading" class="absolute inset-0 flex items-center justify-center">
        <div class="w-6 h-6 border-4 border-t-transparent border-white border-solid rounded-full animate-spin"></div>
      </span>
    </div>

  </div>
</template>

<script setup lang="ts">

import { ref, reactive, onMounted, nextTick } from 'vue';
import Discussion from './Discussion.vue';

let queryVal = ref<string>('');
let answer = ref<string>('');
let question = ref<string>('');
let error = ref<object | null>(null);
let loading = ref<boolean>(false);

type DiscussionType = {
  question: string;
  answer: string;
};

let discussionArr = reactive<DiscussionType[]>([]);

const textareaRef = ref<HTMLTextAreaElement | null>(null);
const discussionRef = ref<HTMLDivElement | null>(null);

const scrollToBottom = () => {
  nextTick(() => {
    if (discussionRef.value) {
      discussionRef.value.scrollTop = discussionRef.value.scrollHeight;
    }
  });
};

const sendQuery = async () => {
  if (error) {
    error.value = null;
  }

  try {
    loading.value = true;

    const response = await fetch(`${import.meta.env.VITE_API_URL}/ask`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        query: queryVal.value,
      }),
    })

    const data = await response.json();

    if (data.error) {
      error.value = data.error;
    } else {
      discussionArr.push({
        question: queryVal.value,
        answer: data.answer
      })

      queryVal.value = '';
      scrollToBottom()
    }
  } catch (error) {
    console.error('Error:', error)
  }

  loading.value = false;
}

// Adjust textarea height

const adjustHeight = () => {
  if (textareaRef.value) {
    textareaRef.value.style.height = "auto";
    textareaRef.value.style.height = `${textareaRef.value.scrollHeight}px`;

    if (textareaRef.value.scrollHeight > 150) {
      textareaRef.value.style.height = '150px';
      textareaRef.value.style.overflowY = "auto";
    }
  }
};

</script>

<style>

/* Scrollbar style */

@media (min-width: 768px) {
  ::-webkit-scrollbar {
    width: 0.5rem;
  }

  ::-webkit-scrollbar-track {
    background: transparent;
  }

  ::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.5);
    border-radius: 6px;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.8);
  }
}

</style>