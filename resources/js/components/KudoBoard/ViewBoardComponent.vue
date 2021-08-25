<template>
    <div>
        <new-post-component
            :dialog="modalNewPost"
            @close="modalNewPost = false"
        />
        <edit-post-component
            :dialog="modalEditPost"
            @close="modalEditPost = false"
        />
        <settings-board-component 
            :dialog="modalSettings"
            @close="modalSettings = false"/>

        <alert
            :dialog="alert.dialog"
            :tipo="alert.tipo"
            :mensaje="alert.mensaje"
            @close="alert.dialog = false"
        />

        <questioner 
            :dialog="questioner.dialog"
            :title="questioner.titulo"
            :message="questioner.mensaje"
            @close="questioner.dialog = false"
            @accept="deletePostBoard()"
        />
        <div class="header-component">
            <div
                class="d-flex justify-end"
                :style="{
                    height: workerPermissions.is_owner ? '' : '30px'
                }"
            >
                <div
                    class="header-buttons"
                    :style="{
                        display: workerPermissions.is_owner ? '' : 'none'
                    }"
                >
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                fab
                                x-small
                                depressed
                                icon
                                v-bind="attrs"
                                v-on="on"
                                ><v-icon color="white"
                                    >mdi-account-group-outline</v-icon
                                ></v-btn
                            >
                        </template>
                        <span>Guests</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                @click="modalSettings = true"
                                fab
                                x-small
                                depressed
                                icon
                                v-bind="attrs"
                                v-on="on"
                                ><v-icon color="white"
                                    >mdi-cog-outline</v-icon
                                ></v-btn
                            >
                        </template>
                        <span>Settings</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                fab
                                x-small
                                depressed
                                icon
                                v-bind="attrs"
                                v-on="on"
                                ><v-icon color="white"
                                    >mdi-delete-outline</v-icon
                                ></v-btn
                            >
                        </template>
                        <span>Delete</span>
                    </v-tooltip>
                </div>
            </div>

            <span class="header-title">{{ board.description }}</span>

            <div
                :style="{
                    display: workerPermissions.is_guest ? '' : 'none'
                }"
                class="btn-posts"
                @click="modalNewPost = true"
            >
                <v-btn rounded><v-icon>mdi-plus</v-icon> NEW POST</v-btn>
            </div>
        </div>
        <div class="posts-component">
            <v-alert v-if="posts.length == 0" dense outlined type="info">
                No posts in this KudoBoard.
            </v-alert>
            <v-row v-else>
                <v-col cols="12" md="4" v-for="(element, i) in posts" :key="i">
                    <v-card>
                        <v-card-actions
                            v-if="workerPermissions.is_guest"
                            class="d-flex justify-end"
                        >
                            <v-menu offset-y>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        x-small
                                        class="mx-1"
                                        fab
                                        depressed
                                        color="white"
                                        v-bind="attrs"
                                        v-on="on"
                                    >
                                        <v-icon color="red">
                                            mdi-dots-horizontal
                                        </v-icon>
                                    </v-btn>
                                </template>
                                <v-list>
                                    <v-list-item link @click="setPost(element),modalEditPost = true">
                                        <v-list-item-title
                                            ><v-icon color="green"
                                                >mdi-pencil-outline</v-icon
                                            >
                                            Edit</v-list-item-title
                                        >
                                    </v-list-item>
                                    <v-list-item link @click="delt(element)">
                                        <v-list-item-title>
                                            <v-icon color="red"
                                                >mdi-delete-outline</v-icon
                                            >
                                            Delete</v-list-item-title
                                        >
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-card-actions>
                        <v-card-text>
                            {{ element.post.description }}
                        </v-card-text>
                        <v-card-text class="d-flex justify-end">
                            From {{ element.worker_name }}
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import EditPostComponent from '../Posts/EditPostComponent.vue';
import NewPostComponent from "../Posts/NewPostComponent.vue";
import SettingsBoardComponent from './SettingsBoardComponent.vue';
import alert from '../Helpers/alert.vue';
import Questioner from '../Helpers/questioner.vue';
export default {
    name: "ViewBoardComponent",
    components: {
        NewPostComponent,
        SettingsBoardComponent,
        EditPostComponent,
        alert,
        Questioner
    },
    data() {
        return {
            modalEditPost:false,
            modalNewPost: false,
            modalSettings:false,

            alert: {
                dialog: false,
                tipo: "success",
                mensaje: "asd"
            },

            questioner: {
                dialog: false,
                titulo: "Delete post",
                mensaje: "Do you want delete this post?"
            },

            itemPost : null,
        };
    },
    methods: {
        ...mapActions(["getPostsOfBoard", "deletePost"]),

        ...mapMutations({
            setPost: "SET_POST"
        }),

        delt(params){
            this.itemPost = params
            this.questioner.dialog = true
        },

        deletePostBoard(){
            this.deletePost(this.itemPost.post.id).then(res=>{
                this.questioner.dialog = false
                this.alert.tipo = res.type;
                this.alert.mensaje = res.message;
                this.alert.dialog = true;
                 this.getPostsOfBoard(this.board.id);
                console.log(res);
            })  
        }


    },
    computed: {
        ...mapGetters({
            workerPermissions: "GET_LIST_PERMISSIONS",
            board: "GET_BOARD",
            posts: "GET_POSTS"
        }),
    },
    created() {
        this.getPostsOfBoard(this.board.id);
    }
};
</script>

<style lang="scss" scoped>
.header-component {
    background: #e65100;
    height: 120px;
    text-align: center;
    box-shadow: 0 3px 6px rgb(0 0 0 / 16%), 0 3px 6px rgb(0 0 0 / 23%);
}
.header-title {
    text-align: center;
    font-weight: 700;
    font-size: 36px;
    color: white;
}
.header-buttons {
    border: 3px solid white;
    width: 115px;
    border-radius: 15px;
    margin-right: 20%;
    margin-top: 10px;
}
.btn-posts {
    position: absolute;
    z-index: 1;
    left: 75px;
    top: 100px;
}
.posts-component {
    padding: 20px 75px 20px 75px;
}
.post {
    padding: 25px;
}
</style>
