import Vue from 'vue'
import VueRouter from 'vue-router'

import CategoriesComponent from '../components/admin/pages/categories/CategoriesComponent'
import DashboardComponent from '../components/admin/pages/dashboard/DashboardComponent'
import AdminComponent from '../components/admin/AdminComponent'

Vue.use(VueRouter)

const routes = [{
    path: '/admin',
    component: AdminComponent,
    children: [
        { path: '', component: DashboardComponent, name: 'admin.dashboard' },
        { path: 'categories', component: CategoriesComponent, name: 'admin.categories' },
    ]
}]

const router = new VueRouter({
    routes
})

export default router