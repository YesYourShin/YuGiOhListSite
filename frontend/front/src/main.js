import Vue from 'vue'
import App from './App.vue'

import router from './router/router'
import vuetify from './plugins/vuetify'

import store from './store/store'


Vue.config.productionTip = false

export const EventBus = new Vue()

new Vue({
  router,
  store:store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
