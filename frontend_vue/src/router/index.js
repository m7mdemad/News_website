import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',

    component: () => import(/* webpackChunkName: "about" */ '../views/Homepage.vue')
  },
  {
    path: '/login',
    name: 'login',

    component: () => import(/* webpackChunkName: "about" */ '../views/Login.vue')
  },
  {
    path: '/register',
    name: 'register',

    component: () => import(/* webpackChunkName: "about" */ '../views/Register.vue')
  },
  {
    path: '/forgotpassword',
    name: 'forgotpassword',

    component: () => import(/* webpackChunkName: "about" */ '../views/ForgotPassword.vue')
  },
  {
    path: '/updatepassword',
    name: 'updatepassword',

    component: () => import(/* webpackChunkName: "about" */ '../views/UpdatePassword.vue')
  },
  {
    path: '/favourites',
    name: 'favourites',

    component: () => import(/* webpackChunkName: "about" */ '../views/Favourites.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  if((to.name === 'updatepassword' && localStorage.getItem("apollo-token") === null) ||
     (to.name === 'favourites' && localStorage.getItem("apollo-token") === null))
  {
        next({ path: 'login'})
  }

  else if((to.name === 'login' && localStorage.getItem("apollo-token") !== null) ||
          (to.name === 'forgotpassword' && localStorage.getItem("apollo-token") !== null))
  {
      next({ path:'/' })
  }

  else next()
})

export default router
