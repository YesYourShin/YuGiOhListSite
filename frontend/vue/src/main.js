import Vue from 'vue'
import App from './App.vue'

import router from './router/router'
import vuetify from './plugins/vuetify'
import VueCookies from 'vue-cookies'

Vue.use(VueCookies)
Vue.$cookies.config("7d");

Vue.config.productionTip = false

export const EventBus = new Vue()

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
