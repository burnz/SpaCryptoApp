import Vue from 'vue'
import Vuex from 'vuex'
import auth from '../app/auth/vuex'
import account from '../app/account/vuex'
import portfolio from '../app/portfolio/vuex'
import admin from '../app/admin/vuex'

Vue.use(Vuex)

import state from './state'
import * as getters from './getters'
import * as actions from './actions'
import * as mutations from './mutations'

export default new Vuex.Store({
	state,
	actions,
	getters,
	mutations,
	modules: {
		auth: auth,
		account: account,
		portfolio: portfolio,
		admin: admin
	}
})