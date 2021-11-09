import Vue from 'vue';
import VueRouter from 'vue-router';
import HelloWorld from '@/components/HelloWorld'; 
import SignUp from '@/components/SignUp';
import SignIn from '@/components/SignIn';
import CardList from '@/components/CardList';

Vue.use(VueRouter); //vue 라우터 사용

export default new VueRouter({ //라우터 연결
    mode:'history',
	routes:[
		{ path:'/', component:HelloWorld }, 
        { path:'/signup',component:SignUp }, 
        { path:'/signin',component:SignIn }, 
        { path:'/cardlist',component:CardList }
		
	]
})