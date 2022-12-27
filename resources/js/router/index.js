
import {createWebHistory, createRouter} from "vue-router";
import Home from '../page/Home';

import Admin from '../admin/Mainpage';
import AdminDashboard from '../admin/Dashboard';
import AdminLibProfile from '../admin/Profile';
import AdminAcademic from '../admin/Academic';
import AdminBook from '../admin/Book';
import AdminJournal from '../admin/Journal';
import AdminMagazine from '../admin/Magazine';
import AdminService from '../admin/Service';
import AdminUser from '../admin/Administrator';
import AdminReport from '../admin/Report';

import User from '../user/Mainpage';
import UserHome from '../user/Home';
import About from '../user/About';
import Academic from '../user/Academic';
import Book from '../user/Book';
import Journal from '../user/Journal';
import Magazine from '../user/Magazine';
import Service from '../user/Service';
import Contact from '../user/Contact';
import Profile from '../user/Profile';

import Login from '../page/Login';
import Register from '../page/Registration';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
        // children:[
        // ]
    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin,
        children:[
            {
                name: 'admindashboard',
                path: '',
                component: AdminDashboard,
            },
            {
                name: 'adminlibprofile',
                path: 'lib-profile',
                component: AdminLibProfile,
            },
            {
                name: 'adminacademic',
                path: 'academic',
                component: AdminAcademic,
            },
            {
                name: 'adminbook',
                path: 'books',
                component: AdminBook,
            },
            {
                name: 'adminjournal',
                path: 'journals',
                component: AdminJournal,
            },
            {
                name: 'adminmagazine',
                path: 'magazines',
                component: AdminMagazine,
            },
            {
                name: 'adminservice',
                path: 'services',
                component: AdminService,
            },
            {
                name: 'adminuser',
                path: 'users',
                component: AdminUser,
            },
            {
                name: 'adminreport',
                path: 'report',
                component: AdminReport,
            },
        ]
    },
    {
        name: 'user',
        path: '/user',
        component: User,
        children:[
            {
                name: 'userhome',
                path: '',
                component: UserHome,
            },
            {
                name: 'about',
                path: 'school-profile',
                component: About,
            },
            {
                name: 'academic',
                path: 'academic',
                component: Academic,
            },
            {
                name: 'book',
                path: 'books',
                component: Book,
            },
            {
                name: 'journal',
                path: 'journals',
                component: Journal,
            },
            {
                name: 'magazine',
                path: 'magazines',
                component: Magazine,
            },
            {
                name: 'service',
                path: 'services',
                component: Service,
            },
            {
                name: 'contact',
                path: 'contact',
                component: Contact,
            },
            {
                name: 'profile',
                path: 'profile',
                component: Profile,
            },
        ]
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const openRoutes = [
     'home',
     'login',
     'register',
     

    

];

const userRoutes = [
    'user',
     'userhome',
     'about',
     'academic',
     'book',
     'journal',
     'magazine',
     'service',
     'contact',
     'profile',
   
   
   
];
const adminRoutes = [
    'admin',
    'admindashboard',
    'adminlibprofile',
    'adminacademic',
    'adminbook',
    'adminjournal',
    'adminmagazine',
    'adminservice',
    'adminuser',
    'adminreport',
    
];


router.beforeEach((to, from, next)=>{
    if(!window.Laravel.isLoggedin){
        if(openRoutes.includes(to.name)){
            return next();
        }
    }else{
        let user = window.Laravel.user;
        if(adminRoutes.includes(to.name) && user.role == 3){
            return next();
        }else if(userRoutes.includes(to.name) && (user.role == 1 || user.role == 0  || user.role == 2)){
            return next();
        }
    }
    if(openRoutes.includes(to.name)){
        return next();
    }else{
       // return next({name:'signin'});
    }
    
   
});
export default router;