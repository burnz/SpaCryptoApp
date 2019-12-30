import Vue from 'vue'
import Router from 'vue-router'
import { routes as routes } from '../app/index'
import beforeEach from './beforeEach'

Vue.use(Router)

console.log(routes)

const router = new Router({
	routes: routes,
	mode: 'history'
})

router.beforeEach(beforeEach)

export default router