<template>
    <v-dialog :value="newBoard" persistent max-width="550px">
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
                    v-model="values"
                    :items="items"
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
                    dense
                    filled
                    rounded
                    placeholder="Happy BD, Team Oeace...."
                ></v-text-field>
            </v-card-text>
            <v-card-actions class="d-flex justify-center">
                <v-btn dark depressed color="blue"> <v-icon>mdi-plus</v-icon> CREATE</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "NewBoardComponent",
    data() {
        return {
            items: ["foo", "bar", "fizz", "buzz"],
            values: ["foo", "bar"],
            value: null
        };
    },
    props: {
        dialog: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        newBoard() {
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
