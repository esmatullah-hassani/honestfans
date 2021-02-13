/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import ChatContent from './components/chat-content/ChatContent';
import PayPalPayment from './components/card/PayPalPayment';
import router from './routes/api.route';
import LifeVideo from './components/chat-content/LifeVideo';
import UploadVideo from './components/upload/UploadVideo';

const app = new Vue({
    el: '#app',
    router,
    components:{
     LifeVideo,

     ChatContent,
     PayPalPayment,
     UploadVideo
    },
 
  });
 