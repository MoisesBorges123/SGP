<template>
  <div class="row">
    <div class="col-12">
      <div
        class="custom-control custom-radio mb-3"
        v-for="value in typesIntentions"
        v-bind:key="value.id"
      >
        <input
          type="radio"
          :value="value.id"
          :id="value.id"
          name="typeThanksGivenIntention"
          class="custom-control-input"
          v-model="intencao"
        />
        <label class="custom-control-label" :for="value.id">{{ value.nome }}</label>
      </div>
    </div>
    <div class="col-12" v-if="intencao == '6'">
      <label for="esposo" class="form-control-label">Esposo</label>
      <input
        class="form-control"
        type="text"
        placeholder="Nome do esposo"
        name="esposo"
        id="esposo"
        :value="esposo"
      />
    </div>
    <div class="col-12" v-if="intencao == '6'">
      <label for="esposa" class="form-control-label">Esposa</label>
      <input
        class="form-control"
        type="text"
        placeholder="Nome do esposa"
        name="esposa"
        id="esposa"
        :value="esposa"
      />
    </div>
    <div class="col-12" v-if="intencao == '5' || intencao == '8'">
      <label for="pessoa" class="form-control-label">Nome</label>
      <input
        class="form-control"
        type="text"
        placeholder="Nome"
        name="pessoa"
        id="pessoa"
        :value="pessoa"
      />
    </div>
    <div class="col-12" v-if="intencao == '5'">
      <label for="esposa" class="form-control-label">Idade do Aniversariante</label>
      <input
        class="form-control"
        type="number"
        placeholder="Idade"
        name="age"
        id="age"
        :value="esposa"
      />
    </div>
    <div class="col-12" v-if="intencao == '6'">
      <label for="married_time" class="form-control-label">Tempo Casados</label>
      <input
        class="form-control"
        type="number"
        placeholder="Tempo que o casal está junto (anos)"
        name="married_time"
        id="married_time"
        :value="anos"
      />
    </div>
    <div class="col-12" v-if="intencao == '7'">
      <label for="evento" class="form-control-label">Curso</label>
      <input
        class="form-control"
        type="text"
        placeholder="Nome do curso dos formandos"
        name="curso"
        id="curso"
        :value="curso"
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
    <div class="col-12" v-if="intencao == '6' || intencao == '7'">
      <div class="form-group">
        <label for="observations" class="form-control-label">Observações</label>
        <textarea
          name="observacao"
          placeholder="Insira algum aviso para repassar para a sacristã"
          id="observacao"
          cols="30"
          rows="5"
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
    "pessoa",
    "data_agendamento",
    "hora_agendamento",
    "agendado_por",
    "observacao",
    "esposo",
    "esposa",
    "curso",
    "telefone",
    "type",
    "anos",
  ],
  data() {
    return {
      intencao: "",
      typesIntentions: [
        {
          id: "5",
          nome: "Pelo aniversário",
        },
        {
          id: "6",
          nome: "Pelo casamento",
        },
        {
          id: "7",
          nome: "Pela graduação",
        },
        {
          id: "8",
          nome: "Pela graça alcançada",
        },
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
