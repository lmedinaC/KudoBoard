import Vue from "vue";
import Vuex from "vuex";
const axios = require("axios");

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        listBoards: [],
        adminComponent: "HomeBoardComponent",
    },

    /*
     * Returns the var states
     */
    getters: {
        GET_LIST_BOARDS(state) {
            return state.listBoards;
        },

        GET_ADMIN_COMPONENT(state) {
            return state.adminComponent;
        }

    },

    mutations: {
        SET_LIST_BOARDS(state, payload) {
            state.listBoards = payload;
        },
        SET_ADMIN_COMPONENT(state, payload) {
            state.adminComponent = payload;
        }
    },

    actions: {
        /*
         *Change the component in home index
         */
        changeAdminComponent({ commit }, payload) {
            commit("SET_ADMIN_COMPONENT", payload);
        },


        getBoards({ commit, dispatch }) {
            return axios
                .get("/board/store")
                .then(response => {
                    console.log(response.data.data);
                    var res = response.data.data;
                    res.forEach(element => {
                        element.recipentsView = []
                        if (element.recipients.length > 0) {
                            for (let i = 0; i < 2; i++) {
                                if (element.recipients[i] !== undefined)
                                    element.recipentsView.push(element.recipients[i])
                            }
                        }
                    });

                    commit('SET_LIST_BOARDS', res);
                    return Promise.resolve(true);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        },

        createBoard({ commit, dispatch }) {
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