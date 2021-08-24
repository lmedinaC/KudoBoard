import Vue from "vue";
import Vuex from "vuex";
const axios = require("axios");

Vue.use(Vuex);

export default new Vuex.Store({
    state: {

    },

    /*
     * Returns the var states
     */
    getters: {

    },

    mutations: {

    },

    actions: {
        getBoards({ commit, dispatch }) {
            return axios
                .post("/board/create", {
                    "description": "Feliz cumple asd amigos",
                    "workers": [1, 2, 3]

                })
                .then(response => {
                    console.log(response);


                    return Promise.resolve(true);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        },

        getPermissionsBoard({ commit, dispatch }) {
            return axios
                .post("/board/permissions/4", {})
                .then(response => {
                    console.log(response);


                    return Promise.resolve(true);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        },
    }
});