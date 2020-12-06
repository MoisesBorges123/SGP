<template>
<div class="row">
    <div class="col-12">
        <label for="pessoa" class="form-control-label">Nome</label>
        <input class="form-control " type="text" placeholder="Nome" name='pessoa' id="pessoa" :value="pessoa">

    </div>    
    <div class='col-12'>
        <scheduling 
        :data_agendamento="data_agendamento" 
        :hora_agendamento="hora_agendamento"
        :agendado_por="agendado_por"
        :telefone="telefone"
        /> 
    </div>
    
</div>
</template>
<script>
import Scheduling from './SchedulingIntention.vue'
export default {
    mounted() {

    },
    props:['pessoa','data_agendamento','hora_agendamento','agendado_por','observacao','telefone'],
    data(){        
        return{}
    },
    components:{
        Scheduling
    }
}
</script>
