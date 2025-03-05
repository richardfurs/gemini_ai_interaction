import './bootstrap';

import { createApp } from 'vue'
import Home from './components/Home.vue'
import Discussion from './components/Discussion.vue'

const app = createApp()

app.component('home', Home).component('discussion', Discussion)

app.mount('#app')
