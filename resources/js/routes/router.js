import { createRouter, createWebHistory } from 'vue-router';
import CustomerView from '../components/customer/CustomerView.vue'

const routes = [

    { name: "CustomerView", component: CustomerView, path: '/' }

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;