<template>
    <div class='row'>
        <div class="col-6">
            <label for="data_agendamento" class="form-control-label">Data Agendamento</label>
            <input class="form-control" type="date" id="data_agendamento" name="data_agendamento" :value="data_agendamento">
        </div>
        <div class="col-6" >
            <label for="hora_agendamento" class="form-control-label">Horário Agendamento</label>
            <input class="form-control" type="text" placeholder="00:00" id="hora_agendamento" name="hora_agendamento" :value='hora_agendamento'>
        </div>
        <div class="col-6">
            <label for="agendado_por" class="form-control-label">Requerente</label>
            <input class="form-control" type="text" placeholder="Requerente" id="agendado_por" name="agendado_por" :value='agendado_por'>
        </div>
        <div class="col-6" >
            <label for="telefone" class="form-control-label">Telefone</label>
            <input class="form-control" v-mask="['(##) ####-####', '(##) #####-####']" type="text" placeholder="Fone do Requerente" id="Telefone" name="telefone[]" :value='telefone'>
        </div>
   </div>     
</template>
<script>
    import {mask} from 'vue-the-mask'

    export default {
        mounted(){
          
        $("#hora_agendamento").timepicki({
            show_meridian:false,
            custom_classes:"box-time",
            min_hour_value:5,
            max_hour_value:22,
            step_size_minutes:30,
            overflow_minutes:true,
            increase_direction:'up',
            disable_keyboard_mobile: true,
            start_time: ["19", "00"]
            });
            

            
        },//FIM MOUNTED



        directives: {mask},
        name:'sheduling',
        props:['data_agendamento','hora_agendamento','agendado_por','telefone'],

       
    }
</script>