import 'timepicki';
window.Vue = require('vue');
import VueTheMask from 'vue-the-mask';
Vue.use(VueTheMask);

Vue.component('intention-tab',require('../components/intentions/IntentionsTabs.vue').default);
Vue.component('thanksgiven',require('../components/intentions/ThanksGivenIntentions.vue').default);
Vue.component('deads',require('../components/intentions/DeadsIntentions.vue').default);
Vue.component('health',require('../components/intentions/HealthIntentions.vue').default);

let app = new Vue({
  el:'#app',
  data(){
    return{
      intentionSelected:false,
    }
  }, 
  methods:{
    selectIntention:function(intencao){
      this.intentionSelected = intencao;
     
    },
  }
});


 
$("#hora_agendamento").timepicki();



