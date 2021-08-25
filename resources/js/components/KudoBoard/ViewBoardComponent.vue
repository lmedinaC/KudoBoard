<template>
    <div>
        <div class="header-component">
            <div class="d-flex justify-end ">
                <div class="header-buttons">
                    <v-btn fab x-small depressed icon
                        ><v-icon color="white">mdi-cog-outline</v-icon></v-btn
                    >
                    <v-btn fab x-small depressed icon
                        ><v-icon color="white">mdi-delete-outline</v-icon></v-btn
                    >
                    
                </div>
            </div>

            <span class="header-title">TITULO DE BOARD</span>
        </div>
        <div class="posts-component">
            <v-row>
                <v-col cols="12" md="4" v-for="(element, i) in items" :key="i">
                    <v-card>
                        <v-card-action class="d-flex justify-end">
                            <v-btn
                                x-small
                                class="mx-1"
                                fab
                                depressed
                                color="white"
                            >
                                <v-icon color="red">
                                    mdi-dots-horizontal
                                </v-icon>
                            </v-btn>
                        </v-card-action>
                        <v-card-text>
                            {{ element.description }}
                        </v-card-text>
                        <v-card-text class="d-flex justify-end">
                            FROM {{ element.guest }}
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script>
export default {
    name: "ViewBoardComponent",
    data() {
        return {
            items: [
                {
                    description:
                        "daslñk jasñdlk jañsd lkjasñ lkjasdñlkj adsñlkjadsñlkjadsñl kajsdñlkasdñlkja",
                    guest: "Luis Medina"
                },
                {
                    description:
                        "daslñk jasñdlk jañsd lkjasñ lkjasdñlkj adsñlkjadsñlkjadsñlkajsdñlkasdñlkja",
                    guest: "Daniel Medina"
                },
                {
                    description:
                        "daslñk jasñdlk jañsd lkjasñ lkjasdñlkj adsñlkjadsñlkjad sñlkajsdñlkasdñlkja",
                    guest: "Jessica Medina"
                }
            ]
        };
    },
    methods: {}
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
    width: 75px;
    border-radius: 15px;
    margin-right: 20%;
    margin-top: 10px;
}
.posts-component {
    padding: 20px 75px 20px 75px;
}
.post {

    padding: 25px;
}
</style>
