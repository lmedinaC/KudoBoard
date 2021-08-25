<template>
    <v-dialog :value="setting" persistent max-width="550px">
        <v-card>
            <v-toolbar color="light-blue darken-4" dark class="pa-0">
                <v-toolbar-title v-html="'Edit KudoBoard'"></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text class="pt-5">
                <label for="titlekudo">Change the KudoBoard title </label>
                <v-text-field
                    dense
                    filled
                    rounded
                    placeholder="Happy BD, Team Oeace...."
                ></v-text-field>

                <label for="titlekudo">N° Guests</label>
                <v-text-field
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
                            v-model="date"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        no-title
                        scrollable
                        v-model="date"
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
                            v-model="date"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        no-title
                        scrollable
                        v-model="date"
                        @input="menu2 = false"
                    ></v-date-picker>
                </v-menu>
            </v-card-text>
            <v-card-actions class="d-flex justify-center">
                <v-btn dark depressed color="blue">
                    <v-icon>mdi-plus</v-icon> CREATE</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "SettingBoardComponent",
    data() {
        return {
            date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),
            menu: false,
            modal: false,
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
        setting() {
            return this.dialog;
        }
    },
    methods: {
        close() {
            this.$emit("close");
        }
    }
};
</script>

<style></style>
