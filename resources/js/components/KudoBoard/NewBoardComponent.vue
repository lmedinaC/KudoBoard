<template>
    <v-dialog :value="newBoard" persistent max-width="550px">
        <alert
            :dialog="alert.dialog"
            :tipo="alert.tipo"
            :mensaje="alert.mensaje"
            @close="alert.dialog = false"
        />
        <v-card>
            <v-toolbar color="light-blue darken-4" dark class="pa-0">
                <v-toolbar-title v-html="'New KudoBoard'"></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text class="pt-5">
                <label for="">Who is this Kudoboard for?</label>

                <v-autocomplete
                    v-model="form.workers"
                    :items="workers"
                    item-text="name"
                    item-value="id"
                    chips
                    clearable
                    deletable-chips
                    dense
                    filled
                    multiple
                    rounded
                    small-chips
                ></v-autocomplete>

                <label for="titlekudo">Title for your KudoBoard</label>

                <v-text-field
                    v-model="form.description"
                    dense
                    filled
                    rounded
                    placeholder="Happy BD, Team Oeace...."
                ></v-text-field>
            </v-card-text>
            <v-card-actions class="d-flex justify-center">
                <v-btn
                    dark
                    depressed
                    color="blue"
                    @click="submit"
                    :loading="loading"
                >
                    <v-icon>mdi-plus</v-icon> CREATE</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import alert from "../Helpers/alert.vue";
export default {
    components: { alert },
    name: "NewBoardComponent",
    data() {
        return {
            form: {
                workers: [],
                description: ""
            },
            loading: false,
            alert: {
                dialog: false,
                tipo: "success",
                mensaje: "asd"
            }
        };
    },
    props: {
        dialog: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        ...mapGetters({
            workers: "GET_LIST_WORKERS"
        }),

        newBoard() {
            return this.dialog;
        }
    },
    methods: {
        ...mapActions(["getWorkers", "createBoard", "getBoards"]),

        close() {
            this.$emit("close");
        },

        submit() {
            if (this.form.description == "" || this.form.workers.length == 0) {
                this.alert.tipo = "warning";
                this.alert.mensaje = "Empty fields!";
                this.alert.dialog = true;
            } else {
                this.loading = true;
                this.createBoard(this.form).then(result => {
                    this.loading = false;
                    console.log(result);
                    console.log(result);
                    this.alert.tipo = result.type;
                    this.alert.mensaje = result.message;
                    this.alert.dialog = true;
                    this.getBoards();
                    this.close();
                });
            }
        }
    },
    created() {
        this.getWorkers();
    }
};
</script>

<style></style>
