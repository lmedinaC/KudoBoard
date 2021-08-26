<template>
    <v-dialog :value="setting" persistent max-width="550px" scrollable>
        <alert
            :dialog="alert.dialog"
            :tipo="alert.tipo"
            :mensaje="alert.mensaje"
            @close="alert.dialog = false"
        />
        <loader :dialog="loader" />
        <v-card >
            <v-toolbar color="light-blue darken-4" dark class="pa-0">
                <v-toolbar-title v-html="'Guest list'"></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text class="pt-5">
                <label for="titlekudo">Select a guest</label>
                <v-row>
                    <v-col cols="10">
                        <v-autocomplete
                            v-model="worker_id"
                            :items="workers"
                            item-text="name"
                            item-value="id"
                            clearable
                            dense
                            filled
                            rounded
                            placeholder="List of guest"
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="2">
                        <v-btn :loading="loading" icon @click="createForm()">
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
                <label for="titlekudo">KudoBoard guest list:</label>
                <v-row no-gutters v-for="(element, i) in guests" :key="i">
                    <v-col :cols="i == 0 ? 12 : 10">
                        <v-text-field
                            v-model="element.worker_name"
                            :prepend-icon="
                                i == 0 ? 'mdi-shield-account' : 'mdi-account'
                            "
                            readonly
                            dense
                            filled
                            rounded
                        ></v-text-field>
                    </v-col>
                    <v-col cols="2" :style="{ display: i == 0 ? 'none' : '' }">
                        <v-btn
                            :loading="loading2"
                            @click="deleteForm(element)"
                            icon
                        >
                            <v-icon>mdi-minus</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import alert from "../Helpers/alert.vue";
import Loader from "../Helpers/loader.vue";
export default {
    components: { alert, Loader },
    name: "GuestsBoardComponent",
    data() {
        return {
            loader: false,
            loading: false,
            loading2: false,
            alert: {
                dialog: false,
                tipo: "success",
                mensaje: "asd"
            },

            worker_id: 0
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
            workers: "GET_LIST_WORKERS",
            board: "GET_BOARD",
            guests: "GET_LIST_GUEST"
        }),

        setting() {
            return this.dialog;
        }
    },
    methods: {
        ...mapActions([
            "getWorkers",
            "getBoard",
            "deleteGuest",
            "createGuest",
            "getGuests"
        ]),

        close() {
            this.$emit("close");
        },

        createForm() {
            const form = {
                guest_id: this.worker_id,
                board_id: this.board.id
            };
            if (this.worker_id == 0 || typeof this.worker_id == "string") {
                this.alert.tipo = "warning";
                this.alert.mensaje = "Select a worker!";
                this.alert.dialog = true;
            } else {
                this.loading = true;
                this.createGuest(form).then(result => {
                    this.alert.tipo = result.type;
                    this.alert.mensaje = result.message;
                    this.alert.dialog = true;
                    this.loading = false;
                    this.getGuests(this.board.id);
                });
            }
        },

        deleteForm(params) {
            this.loading2 = true;
            this.deleteGuest(params.id).then(result => {
                this.alert.tipo = result.type;
                this.alert.mensaje = result.message;
                this.alert.dialog = true;
                this.loading2 = false;
                this.getGuests(this.board.id);
            });
        }
    },
    created() {
        this.getWorkers();
    }
};
</script>

<style></style>
