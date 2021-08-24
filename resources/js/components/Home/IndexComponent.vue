<template>
    <v-app>
       
    </v-app>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: "IndexComponent",
    methods: {
        ...mapActions(["getBoards","getPermissionsBoard"]),

    },
    created(){
        this.getBoards();
        this.getPermissionsBoard();
    }
};
</script>

<style lang="scss" scoped>
    .indexComponent{
        margin: 10px 25px 10px 25px;
    }
</style>


