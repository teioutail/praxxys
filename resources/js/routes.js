// Product Component
let product = require('./components/product/index.vue').default;
let storeproduct = require('./components/product/create.vue').default;
let editproduct = require('./components/product/edit.vue').default;

// Category Component
let category = require('./components/category/index.vue').default;
let storecategory = require('./components/category/create.vue').default;

// Videos Component
let video = require('./components/video/index.vue').default;

// Vue Routes
export const routes = [
    { path: '/product', component: product, name: 'product' },
    { path: '/store-product', component: storeproduct, name: 'store-product' },
    { path:'/edit-product', component: editproduct, name: 'edit-product'},

    { path: '/store-category', component: storecategory, name: 'store-category' },
    { path: '/category', component: category, name: 'category' },

    { path: '/video', component: video, name: 'video' },
  ]
