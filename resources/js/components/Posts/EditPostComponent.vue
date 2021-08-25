<template>
    <v-dialog :value="edit" persistent max-width="550px">
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
                <h3>Edit post...</h3>
                <span>Edit your post in this KudoBoard...</span>
                <v-textarea
                    v-model="post.post.description"
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
                    <v-icon>mdi-pencil </v-icon> EDIT</v-btn
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
            post: "GET_POST",
            board:"GET_BOARD"
        }),

        edit() {
            return this.dialog;
        }
    },
    methods: {
        ...mapActions(["editPost", "getPostsOfBoard"]),

        close() {
            this.$emit("close");
        },

        submit() {
            if (this.post.post.description == "" ) {
                this.alert.tipo = "warning";
                this.alert.mensaje = "Empty fields!";
                this.alert.dialog = true;
            } else {
                const form = {
                    publication_id: this.post.post.id,
                    description: this.post.post.description
                }
                this.loading = true;
                this.editPost(form).then(result => {
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
    
};
</script>

<style></style>
