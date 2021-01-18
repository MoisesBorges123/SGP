<template>
  <div class="row">
    <div class="col-3">
      <div
        class="custom-control custom-radio mb-3"
        v-for="value in typesIntentions"
        v-bind:key="value.id"
      >
        <input
          type="radio"
          v-model="intencao"
          :value="value.id"
          :id="value.id"
          name="tipo_intencao"
          class="custom-control-input"
        />
        <label class="custom-control-label" :for="value.id">{{ value.nome }}</label>
      </div>
    </div>
    <div class="col-12" v-if="intencao">
      <label for="falecido" class="form-control-label">Nome do Falecido</label>
      <input
        class="form-control"
        type="text"
        placeholder="Falecido"
        name="falecido"
        id="falecido"
        :value="falecido"
      />
    </div>
    <div class="col-9" v-if="intencao == 3" id="tempo_falecimento">
      <input
        class="form-control"
        type="text"
        placeholder="Tempo de falecimento"
        name="tempo_falecimento"
        id="tempo_falecimento"
      />
    </div>
    <div class="col-12" v-if="intencao">
      <scheduling
        :data_agendamento="data_agendamento"
        :hora_agendamento="hora_agendamento"
        :agendado_por="agendado_por"
        :telefone="telefone"
      />
    </div>
    <div class="col-12" v-if="intencao">
      <div class="form-group">
        <label for="padrinho" class="form-control-label">Observações</label>
        <textarea
          name="observacao"
          placeholder="Insira algum aviso para repassar para a sacristã"
          id="observacao"
          cols="30"
          rows="10"
          class="form-control"
          :value="observacao"
        ></textarea>
      </div>
    </div>
  </div>
</template>
<script>
import Scheduling from "./SchedulingIntention.vue";
export default {
  mounted() {
    this.intencao = this.find_type_intention(this.type);
  },
  props: [
    "falecido",
    "data_agendamento",
    "hora_agendamento",
    "agendado_por",
    "observacao",
    "telefone",
    "type",
  ],
  data() {
    return {
      intencao: "",
      typesIntentions: [
        { id: 1, nome: "7º dia" },
        { id: 2, nome: "30º dia" },
        { id: 3, nome: "Falecidos" },
      ],
    };
  },
  components: {
    Scheduling,
  },
  methods: {
    find_type_intention: function (type) {
      var intencao;
      Array.from(this.typesIntentions).forEach(function (value) {
        if (value.nome == type) {
          intencao = value.id;
        }
      });
      return intencao;
    },
  },
};
</script>
