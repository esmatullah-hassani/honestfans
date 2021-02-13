import VueRouter from 'vue-router';
import Vue from 'vue';
import IndexContent from '../components/chat-content/hero-content/IndexContent';
import VideoChatContent from '../components/chat-content/hero-content/VideoChatContent';
import MessageContent from '../components/chat-content/hero-content/MessageContent';
import ByeCoin from '../components/card/ByeCoin';
Vue.use(VueRouter);

const router = new VueRouter({
    routes:[
        
        {
            path:"users/:id",
            component:VideoChatContent,
        },
        {
            path:"/users-message",
            component:MessageContent
        },
        {
            path:'/bye-coin/:id',
            component:ByeCoin,
        }
    ]
});

export default router;