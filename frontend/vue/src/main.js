import Vue from 'vue'
import App from './App.vue'

import router from './router/router'
import vuetify from './plugins/vuetify'
import VueCookie from 'vue-cookie'

Vue.use(VueCookie)
Vue.config.productionTip = false

export const EventBus = new Vue()

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
