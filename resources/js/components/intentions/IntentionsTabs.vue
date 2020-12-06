<template>
<div class='row align-items-center text-center' id="intentions-tabs">
    <div class='col-12'>
        <h1>Qual intenção vai ser??</h1>
    </div>
    <div class='col-4 bg-warning' id="thanksGiven-tab" v-on:click="selectIntentions('Ação de Graças')">
        <span>Ação de Graças</span>
    </div>
    <div class='col-4 bg-default' v-on:click="selectIntentions('Falecimento')">
        <span>Falecimento</span>
    </div>
    <div class='col-4 bg-primary' v-on:click="selectIntentions('Saúde')" id='health-tab'>
        <span>Saúde</span>
    </div>
</div>
</template>

<script>
export default {
    mounted() {

    },
    data() {
        return {
            intention: '',
            }
    },
    methods: {
        selectIntentions: function (titulo) {
            this.intention = titulo;
            this.$emit('select_intentions', this.intention);
        }
    }
}
</script>
