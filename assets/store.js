import { createStore } from 'vuex';

const store = createStore({
    state() {
        return {
            count: 4
        };
    },
    mutations: {
        decrementCount(state) {
            state.count--;
        },
        updateCount(state, payload) {
            state.count = payload;
        }
    },
    actions: {
        decrementCount({ commit }) {
            commit('decrementCount');
        },
        updateCount({ commit }, payload) {
            commit('updateCount', payload);
        },
    },

});

export default store;
