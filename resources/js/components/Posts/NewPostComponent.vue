<template>
    <v-dialog :value="newPost" persistent max-width="550px">
        <alert
            :dialog="alert.dialog"
            :tipo="alert.tipo"
            :mensaje="alert.mensaje"
            @close="alert.dialog = false"
        />
        <v-card>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn icon @click="close">
                    <v-icon color="red">mdi-close</v-icon>
                </v-btn>
            </v-card-actions>
            <v-card-text>
                <h3>New post...!!!</h3>
                <span>Write your post in this KudoBoard...</span>
                <v-textarea
                    v-model="form.description"
                    dense
                    filled
                    rounded
                    no-resize
                    rows="5"
                    placeholder="Hello...."
                ></v-textarea>
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
    name: "NewPostComponent",
    data() {
        return {
            form: {
                board_id : 0,
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
            board: "GET_BOARD",
        }),

        newPost() {
            return this.dialog;
        }
    },
    methods: {
        ...mapActions(["getWorkers", "createPost", "getPostsOfBoard"]),

        close() {
            this.$emit("close");
        },

        submit() {
            if (this.form.description == "" ) {
                this.alert.tipo = "warning";
                this.alert.mensaje = "Empty fields!";
                this.alert.dialog = true;
            } else {
                this.form.board_id = this.board.id;
                this.loading = true;
                this.createPost(this.form).then(result => {
                    this.loading = false;
                    //console.log(result);
                    this.alert.tipo = result.type;
                    this.alert.mensaje = result.message;
                    this.alert.dialog = true;
                    this.getPostsOfBoard(this.board.id);
                    this.close();
                });
            }
        }
    },
    created() {
        this.getPostsOfBoard(this.board.id);
    }
};
</script>

<style></style>
