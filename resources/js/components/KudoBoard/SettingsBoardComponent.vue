<template>
    <v-dialog :value="setting" persistent max-width="550px" scrollable>
        <alert
            :dialog="alert.dialog"
            :tipo="alert.tipo"
            :mensaje="alert.mensaje"
            @close="alert.dialog = false"
        />
        <v-card>
            <v-toolbar color="light-blue darken-4" dark class="pa-0">
                <v-toolbar-title v-html="'Edit KudoBoard'"></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text class="pt-5">
                <label for="">Change KudoBoard recipients</label>

                <v-autocomplete
                    v-model="boardForm.workers"
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

                <label for="titlekudo">Change the KudoBoard title </label>
                <v-text-field
                    v-model="boardForm.description"
                    dense
                    filled
                    rounded
                    placeholder="Happy BD, Team Oeace...."
                ></v-text-field>

                <label for="titlekudo">N° Guests</label>
                <v-text-field
                    v-model="boardForm.num_max_guest"
                    type="number"
                    :max="1000"
                    :min="1"
                    dense
                    filled
                    rounded
                    prepend-icon="mdi-account-group-outline"
                    placeholder="1-1000"
                ></v-text-field>

                <label for="titlekudo">Date start of posts</label>
                <v-menu
                    v-model="menu1"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            dense
                            filled
                            rounded
                            v-model="boardForm.start_date"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        :min="date"
                        no-title
                        scrollable
                        v-model="boardForm.start_date"
                        @input="menu1 = false"
                    ></v-date-picker>
                </v-menu>
                <label for="titlekudo">Date end of posts</label>
                <v-menu
                    v-model="menu2"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            dense
                            filled
                            rounded
                            v-model="boardForm.end_date"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        :min="boardForm.end_date == null ? date : boardForm.start_date"
                        no-title
                        scrollable
                        v-model="boardForm.end_date"
                        @input="menu2 = false"
                    ></v-date-picker>
                </v-menu>
            </v-card-text>
            <v-card-actions class="d-flex justify-center">
                <v-btn
                    dark
                    depressed
                    color="blue"
                    @click="submit"
                    :loading="loading"
                >
                    <v-icon>mdi-pencil </v-icon> EDIT</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import alert from '../Helpers/alert.vue';
export default {
    components: { alert },
    name: "SettingBoardComponent",
    data() {
        return {
            loading: false,
            alert: {
                dialog: false,
                tipo: "success",
                mensaje: "asd"
            },
            date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),
            date2: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),
            menu1: false,
            menu2: false
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
            board: "GET_BOARD"
        }),

        mindDateToEnd(){
            if(this.board.start_date == null)
                return this.date
            else    
                return this.date
        },

        boardForm() {
            this.board.workers = [];
            this.board.recipients.forEach(element => {
                this.board.workers.push(element.worker_id);
            });
            return JSON.parse(JSON.stringify(this.board));
        },

        setting() {
            return this.dialog;
        }
    },
    methods: {
        ...mapActions(["getWorkers","editBoard","getBoard"]),

        close() {
            this.$emit("close");
        },

        submit(){
            const formTemp = JSON.parse(JSON.stringify(this.boardForm));
            var form = {
                id : formTemp.id,
                num_max_guest : formTemp.num_max_guest,
                description : formTemp.description,
                workers : formTemp.workers,
                start_date : formTemp.start_date,
                end_date : formTemp.end_date,
            }
            if(form.num_max_guest <=0 || form.num_max_guest >1000){
                this.alert.tipo = "warning";
                this.alert.mensaje = "Number of guests must be greater than 0";
                this.alert.dialog = true;
            }else if (form.description == "" || form.workers.length == 0) {
                this.alert.tipo = "warning";
                this.alert.mensaje = "The title or recipients must not be empty!";
                this.alert.dialog = true;
            } else {
                console.log(form);
                this.loading = true;
                this.editBoard(form).then(result => {
                    this.loading = false;
                    console.log(result);
                    this.alert.tipo = result.type;
                    this.alert.mensaje = result.message;
                    this.alert.dialog = true;
                    this.getBoard(formTemp.id)
                    this.close();
                });
            };
        }
    },
    created() {
        this.getWorkers();
    }
};
</script>

<style></style>
