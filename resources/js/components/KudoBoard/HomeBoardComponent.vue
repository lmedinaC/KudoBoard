<template>
    <div>
        <v-tabs v-model="tab" centered color="blue" >
            <v-tab v-for="(item,i) in items" :key="i">
                {{ item.name }}
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item v-for="item in items" :key="item">
                <div class="indexComponent">
                     <component v-bind:is="item.component" ></component>
                </div>
               
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import ListBoardsComponent from "./ListBoardsComponent.vue";
import RecipientBoardsComponents from "./RecipientBoardsComponent.vue"

import { mapActions, mapGetters } from "vuex";

export default {
    name: "HomeBoardComponent",
    components: { ListBoardsComponent,RecipientBoardsComponents },
    data() {
        return {
            tab:null,
            items: [
                {name:"Boards", component: 'ListBoardsComponent'},
                {name:"Recipients", component: 'RecipientBoardsComponents'}
            ]
        };
    },
    methods: {
        ...mapActions(["changeAdminComponent"])
    },
    
};
</script>

<style lang="scss" scoped>
.indexComponent {
    padding: 20px 75px 20px 75px;
    background: #f9f9fa;
}
</style>
