<template>
    <div>
        <loader :dialog="loader" />
        <alert
            :dialog="alert.dialog"
            :tipo="alert.tipo"
            :mensaje="alert.mensaje"
            @close="alert.dialog = false"
        />
        <v-alert v-if="listBoard.length == 0" dense outlined type="info">
                You haven't received a KudoBoard yet.
        </v-alert>
        <v-row v-else>
            <v-col v-for="(e, i) in listBoard" :key="i" cols="12" sm="4">
                <v-card elevation="2">
                    <v-card-text>
                        <v-row>
                            <v-col cols="8">
                                <p class="text-h6 text--primary">
                                    <strong>{{ e.description }}</strong>
                                </p>
                            </v-col>
                            <v-col cols="4" class="d-flex justify-end">
                                <v-btn
                                    @click="openBoard(e)"
                                    dark
                                    depressed
                                    color="blue"
                                    ><v-icon small class="mr-2"
                                        >mdi-bulletin-board</v-icon
                                    >View</v-btn
                                >
                            </v-col>
                        </v-row>
                        <v-alert
                            v-if="e.recipients.length == 0"
                            dense
                            outlined
                            type="error"
                        >
                            No recipients.
                        </v-alert>
                        <div v-else>
                            <span style="display:block; margin-bottom:5px;"
                                >FOR:</span
                            >
                            <v-tooltip
                                bottom
                                v-for="(el, i) in e.recipentsView"
                                :key="i"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-avatar
                                        v-bind="attrs"
                                        v-on="on"
                                        :color="randomColor()"
                                        size="48"
                                        class="ml-1"
                                    >
                                        <span class="white--text text-h6">{{
                                            el.name.substr(0, 1).toUpperCase()
                                        }}</span>
                                    </v-avatar>
                                </template>
                                <span>{{ el.name }}</span>
                            </v-tooltip>

                            <v-btn
                                v-if="
                                    e.recipients.length > 5 &&
                                        e.recipients.length !=
                                            e.recipentsView.length
                                "
                                small
                                class="mx-1"
                                fab
                                depressed
                                color="white"
                                @click="allRecipientsView(e)"
                            >
                                <v-icon color="cyan">
                                    mdi-plus
                                </v-icon>
                            </v-btn>
                            <v-btn
                                v-if="
                                    e.recipients.length > 5 &&
                                        e.recipients.length ==
                                            e.recipentsView.length
                                "
                                small
                                class="mx-1"
                                fab
                                depressed
                                color="white"
                                @click="recipientsView(e)"
                            >
                                <v-icon color="red">
                                    mdi-minus
                                </v-icon>
                            </v-btn>
                            <hr />
                        </div>
                    </v-card-text>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" sm="6">
                                <v-icon color="green darken-2"
                                    >mdi-account</v-icon
                                >
                                CREATOR:
                                {{ e.owner.name }}
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-icon color="green darken-1"
                                    >mdi-account-group</v-icon
                                >
                                GUESTS: {{ e.num_guest }} /
                                {{ e.num_max_guest }}
                            </v-col>
                        </v-row>
                        <v-icon>mdi-android-messages</v-icon> POSTS: {{e.num_post}}
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Alert from "../Helpers/alert.vue";
import Loader from "../Helpers/loader.vue";

export default {
    name: "RecipientBoardsComponent",
    components: { Loader, Alert },
    data() {
        return {
            loader: false,
            alert: {
                dialog: false,
                tipo: "success",
                mensaje: "asd"
            },
            colors: [
                { hex: "#c91162" },
                { hex: "#4f3947" },
                { hex: "#a3f3a6" },
                { hex: "#1a355b" },
                { hex: "#62baf9" }
            ]
        };
    },
    methods: {
        ...mapActions(["changeAdminComponent", "getPermissionsBoard","getBoard","getRecipientsBoards"]),

        recipientsView(params) {
            params.recipentsView = [];
            for (let i = 0; i < 5; i++) {
                if (params.recipients[i] !== undefined)
                    params.recipentsView.push(params.recipients[i]);
            }
        },

        allRecipientsView(params) {
            params.recipentsView = [];
            params.recipients.forEach(e => {
                params.recipentsView.push(e);
            });
        },

        randomColor() {
            const color = this.colors[
                Math.floor(Math.random() * this.colors.length)
            ];
            return color.hex;
        },

        openBoard(params) {
            this.loader = true;
            this.getPermissionsBoard(params.id).then(res => {
                this.loader = false;
                if (
                    this.workerPermissions.is_guest == false &&
                    this.workerPermissions.is_owner == false &&
                    this.workerPermissions.is_recipient == false
                ) {
                    this.alert.tipo = "warning";
                    this.alert.mensaje =
                        "You don´t have permissions to this boards";
                    this.alert.dialog = true;
                } else {
                    this.getBoard(params.id).then(resp => {
                         this.changeAdminComponent("ViewBoardComponent");
                    })
                }
            });
        }
    },
    computed: {
        ...mapGetters({
            listBoard: "GET_LIST_RECIPIENTS_BOARDS",
            workerPermissions: "GET_LIST_PERMISSIONS"
        })
    },
    created() {
      this.getRecipientsBoards();
    }
};
</script>

<style lang="scss" scoped></style>
