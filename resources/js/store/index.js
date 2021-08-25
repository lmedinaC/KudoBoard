import Vue from "vue";
import Vuex from "vuex";
const axios = require("axios");

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        adminComponent: "HomeBoardComponent",
        listBoards: [],
        listWorkers: [],
        listPermission: [],
        board: null,
        posts: [],
        post: {
            guest_id: 0,
            post: {
                id: "",
                description: "",
            },
            worker_id: 0,
            worker_name: ""
        }
    },

    /*
     * Returns the var states
     */
    getters: {
        /*
         * Return list of boards
         */
        GET_LIST_BOARDS(state) {
            return state.listBoards;
        },

        /*
         * Return the component
         */
        GET_ADMIN_COMPONENT(state) {
            return state.adminComponent;
        },

        /*
         * Return list of workers
         */
        GET_LIST_WORKERS(state) {
            return state.listWorkers;
        },

        /*
         * Return list of worker permisions to a board
         */
        GET_LIST_PERMISSIONS(state) {
            return state.listPermission
        },

        /*
         * Return KUDO BOARD
         */
        GET_BOARD(state) {
            return state.board
        },

        /*
         * Return  KUDO BOARD´s posts
         */
        GET_POSTS(state) {
            return state.posts
        },

        /*
         * Return  KUDO BOARD´s post
         */
        GET_POST(state) {
            return state.post
        },



    },

    mutations: {
        /*
         * Set list of boards
         */
        SET_LIST_BOARDS(state, payload) {
            state.listBoards = payload;
        },

        /*
         * Set the component to see
         */
        SET_ADMIN_COMPONENT(state, payload) {
            state.adminComponent = payload;
        },

        /*
         * Set list of workers
         */
        SET_LIST_WORKERS(state, payload) {
            state.listWorkers = payload;
        },

        /*
         * Set list of worker permisions to a board
         */
        SET_LIST_PERMISSIONS(state, payload) {
            state.listPermission = payload
        },

        /*
         * Set KUDO BOARD
         */
        SET_BOARD(state, payload) {
            state.board = payload
        },

        /*
         * Set  KUDO BOARD´s posts
         */
        SET_POSTS(state, payload) {
            state.posts = payload
        },

        /*
         * Set  KUDO BOARD´s post
         */
        SET_POST(state, payload) {
            state.post = JSON.parse(JSON.stringify(payload));
        },

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
                    //console.log(response.data.data);
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

        getBoard({ commit, dispatch }, board_id) {
            return axios
                .get(`/board/show/${board_id}`)
                .then(response => {
                    //console.log(response);      
                    commit('SET_BOARD', response.data.data);
                    return Promise.resolve(true);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        },

        getPostsOfBoard({ commit, dispatch }, board_id) {
            return axios
                .get(`/publication/show/${board_id}`)
                .then(response => {
                    console.log(response);
                    commit('SET_POSTS', response.data);
                    return Promise.resolve(true);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        },

        getWorkers({ commit, dispatch }) {
            return axios
                .get("/worker/store")
                .then(response => {
                    //console.log(response.data.data);
                    commit('SET_LIST_WORKERS', response.data.data);
                    return Promise.resolve(true);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        },

        getPermissionsBoard({ commit, dispatch }, board_id) {
            return axios
                .post(`/board/permissions/${board_id}`, {})
                .then(response => {
                    //console.log(response);
                    commit("SET_LIST_PERMISSIONS", response.data.data)
                    return Promise.resolve(true);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        },


        createBoard({ commit, dispatch }, form) {
            return axios
                .post("/board/create", form)
                .then(response => {
                    //console.log(response);
                    return Promise.resolve(response.data);
                })
                .catch(function(error) {
                    //console.log(error);
                    return Promise.resolve(false);
                });
        },

        createPost({ commit, dispatch }, form) {
            return axios
                .post("/publication/create", form)
                .then(response => {
                    //console.log(response);
                    return Promise.resolve(response.data);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        },

        editPost({ commit, dispatch }, form) {
            return axios
                .put("/publication/update", form)
                .then(response => {
                    //console.log(response);
                    return Promise.resolve(response.data);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        },

        deletePost({ commit, dispatch }, post_id) {
            return axios
                .delete(`/publication/delete/${post_id}`, {})
                .then(response => {
                    //console.log(response);
                    return Promise.resolve(response.data);
                })
                .catch(function(error) {
                    console.log(error);
                    return Promise.resolve(false);
                });
        }


    }
});