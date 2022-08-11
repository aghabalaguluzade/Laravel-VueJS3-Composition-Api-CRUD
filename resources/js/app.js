import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue/dist/vue.esm-bundler'
import router from "./router"

import EmployeeIndex from "./components/EmployeeIndex.vue"

const app = createApp({})

app.use(router)
app.mount("#app")
app.component(EmployeeIndex)