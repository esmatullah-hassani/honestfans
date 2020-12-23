import VueRouter from 'vue-router';
import Vue from 'vue';
import IndexContent from '../components/chat-content/hero-content/IndexContent';

Vue.use(VueRouter);

const router = new VueRouter({
    routes:[
        {
            path:"/",
            component:IndexContent,
        }
    ]
});

export default router;