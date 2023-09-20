import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/ProductsView.vue')
    },
    {
      path : '/create' ,
      name : 'create' ,
      component : () => import('../views/CreateProductView.vue')
    }
  ]
})

export default router
