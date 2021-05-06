Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-persian-date', require('./components/IndexField'))
  Vue.component('detail-nova-persian-date', require('./components/DetailField'))
  Vue.component('form-nova-persian-date', require('./components/FormField'))
})
