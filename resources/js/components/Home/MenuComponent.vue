<template>
    <div class="menu-component">
        <new-board-component
            :dialog="modalNewBoard"
            @close="modalNewBoard = false"
        />
        <v-row>
            <v-col cols="8">
                <span
                    class="pointer"
                    @click="changeAdminComponent('HomeBoardComponent')"
                    >Home</span
                >
                <span v-if="component != 'HomeBoardComponent'">
                    / {{ name_board }}</span
                >
            </v-col>
            <v-col cols="4" class="d-flex justify-end">
                <v-btn
                    @click="modalNewBoard = true"
                    small
                    outlined
                    color="blue darken-2"
                    dark
                >
                    <v-icon>mdi-plus</v-icon> NEW BOARD
                </v-btn>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import NewBoardComponent from "../KudoBoard/NewBoardComponent.vue";

export default {
    name: "MenuComponent",
    components: {
        NewBoardComponent
    },
    data() {
        return {
            name_board: "Prueba",
            modalNewBoard: false
        };
    },
    methods: {
        ...mapActions(["changeAdminComponent"])
    },
    computed: {
        ...mapGetters({ component: "GET_ADMIN_COMPONENT" })
    }
};
</script>

<style lang="scss" scoped>
.menu-component {
    background: #fff;
    padding: 20px 75px 20px 75px;
}
.pointer {
    cursor: pointer;
    font-family: museo-sans, Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 18px;
    font-weight: 500;
    line-height: 1.375em;
}
</style>
