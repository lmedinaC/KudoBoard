<template>
  <div>
    <v-dialog :value="question" max-width="600px" persistent>
      <v-card >
        <v-card-title class="headline" style="color:#01579B;">
          {{ title }}
        </v-card-title>

        <v-card-text>
          <div >
            {{ message }}
          </div>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text  color="primary"  @click="accept">
            Accept
          </v-btn>
          <v-btn text color="#80122A" dark @click="close">
            Cancel
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: "Questioner",
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default: "TITULO",
    },
    message: {
      type: String,
      default: "MENSAJasdasdasdsdE",
    },
  },
  computed: {
    question() {
      return this.dialog;
    },
  },
  methods: {
    //CIERRA EL MODAL
    close() { 
      this.$emit("close");
    },
    //EMITIR FUNCION DEL PADRE AL PONER ACEPTAR
    accept() {
      this.$emit("accept");
    },
  },
};
</script>

<style></style>