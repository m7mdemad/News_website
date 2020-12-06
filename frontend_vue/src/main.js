import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import AOS from "aos";
import "aos/dist/aos.css";
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import 'bootstrap/dist/css/bootstrap.min.css'
import '@/assets/css/main.css'

import { createProvider } from './vue-apollo'

Vue.use(Vuetify)

Vue.config.productionTip = false

new Vue({
  router,
  store,

  created() {
    AOS.init({ disable: "phone" });  },

  apolloProvider: createProvider(),
  render: h => h(App)
}).$mount('#app')
