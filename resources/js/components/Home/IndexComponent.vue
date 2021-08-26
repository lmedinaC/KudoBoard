<template>
    <v-app style="background: #f9f9fa;">
        <menu-component />
        <div>
            <component v-bind:is="component"></component>
        </div>
        
    </v-app>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import ListBoardsComponent from "../KudoBoard/ListBoardsComponent.vue";
import HomeBoardComponent from "../KudoBoard/HomeBoardComponent.vue"
import MenuComponent from "./MenuComponent.vue"
import ViewBoardComponent from "../KudoBoard/ViewBoardComponent.vue"
export default {
    components: { ListBoardsComponent,MenuComponent,HomeBoardComponent,ViewBoardComponent },
    name: "IndexComponent",
    methods: {
        ...mapActions(["getPermissionsBoard"])
    },
    computed: {
        ...mapGetters({component: "GET_ADMIN_COMPONENT"})
    },
    created() {
        
        //this.getPermissionsBoard();
    }
};
</script>

<style lang="scss" scoped>
.indexComponent {
    margin: 20px 75px 20px 75px;
}
</style>
