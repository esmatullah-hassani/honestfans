import VueRouter from 'vue-router';
import Vue from 'vue';
import IndexContent from '../components/chat-content/hero-content/IndexContent';
import VideoChatContent from '../components/chat-content/hero-content/VideoChatContent';
import MessageContent from '../components/chat-content/hero-content/MessageContent';

Vue.use(VueRouter);

const router = new VueRouter({
    routes:[
        {
            path:"/",
            component:IndexContent,
        },
        {
            path:"users/:id",
            component:VideoChatContent,
        },
        {
            path:"/users-message",
            component:MessageContent
        }
    ]
});

export default router;