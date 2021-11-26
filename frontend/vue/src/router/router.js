import Vue from 'vue';
import VueRouter from 'vue-router';
import HelloWorld from '@/components/HelloWorld'; 
import SignUp from '@/components/SignUp';
import SignIn from '@/components/SignIn';
import CardList from '@/components/CardList';
import TestPage from '@/components/TestPage';
import CardItem from '@/components/CardItem';

Vue.use(VueRouter); //vue 라우터 사용

export default new VueRouter({ //라우터 연결
    mode:'history',
	routes:[
		{ path:'/', component:HelloWorld, name:'home'}, 
        { path:'/signup',component:SignUp, name:'signup'}, 
        { path:'/signin',component:SignIn, name:'signin' }, 
        { path:'/cardlist',component:CardList, name:'cardlist' },
        { path:'/testpage',component:TestPage, name:'testpage' },
        { path:'/show/:id',component:CardItem , name:'show'}
        
		
	]
})