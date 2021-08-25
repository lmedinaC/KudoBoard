<template>
    <div>
        <v-row>
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
                                <v-btn @click="openBoard(e)" dark depressed color="blue"
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
                                    e.recipients.length > 2 &&
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
                                    e.recipients.length > 2 &&
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
                        <v-icon>mdi-android-messages</v-icon> POSTS: 100
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    name: "ListBoardsComponent",
    data() {
        return {
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
        ...mapActions(["changeAdminComponent"]),
        recipientsView(params) {
            params.recipentsView = [];
            for (let i = 0; i < 2; i++) {
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
        openBoard(params){
            this.changeAdminComponent("ViewBoardComponent")
        }
    },
    computed: {
        ...mapGetters({
            listBoard: "GET_LIST_BOARDS"
        })
    },
    created() {}
};
</script>

<style lang="scss" scoped>

</style>
