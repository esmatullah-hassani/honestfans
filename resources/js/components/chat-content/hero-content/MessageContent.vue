<template>
<div class="container-fluid " style="float:left;">
    <div class="row justify-content-center ">
        
        <div class=" chat">
            <div class="card">
                <div class="card-header msg_head">
                    <div class="d-flex bd-highlight">
                        <div class="img_cont">
                            <!-- <img v-if="user.social_path!=null" :src="user.social_path"   class="rounded-circle user_img_msg"> -->
                            <!-- <img v-else :src="'/images/avatar/'+user.image"   class="rounded-circle user_img_msg"> -->
                            <span class="online_icon"></span>
                        </div>
                        <div class="user_info">
                            <span style="color:black">Chat with {{user.name}}</span>
                            <p>1767 Messages</p>
                        </div>
                        <div class="video_cam">
                            <span><i class="fas fa-video"></i></span>
                            <span><i class="fas fa-phone"></i></span>
                        </div>
                    </div>
                    <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
                    <div class="action_menu">
                        <ul>
                            <li><i class="fas fa-user-circle"></i> View profile</li>
                            <li><i class="fas fa-users"></i> Add to close friends</li>
                            <li><i class="fas fa-plus"></i> Add to group</li>
                            <li><i class="fas fa-ban"></i> Block</li>
                        </ul>
                    </div>
                </div>
                <div class="card-body msg_card_body">
                    
                   <div v-for="message in allMessages" v-bind:key="message.id">
                       <div  class="d-flex justify-content-start mb-4">
                            <div class="img_cont_msg">
                                 <!-- <img v-if="user.social_path!=null" :src="user.social_path"   class="rounded-circle user_img_msg"> -->
                                <!-- <img v-else :src="'/images/avatar/'+user.image"   class="rounded-circle user_img_msg"> -->
                            </div>
                            <div class="msg_cotainer">
                                {{message.content}}
                                <span class="msg_time">8:40 AM, Today</span>
                            </div>
                        </div>
                        <div  class="d-flex justify-content-end mb-4">
                            <div class="msg_cotainer_send">
                                {{message.content}}
                                <span class="msg_time_send">8:55 AM, Today</span>
                            </div>
                            <div class="img_cont_msg">
                                <img v-if="authuser.social_path!=null" :src="authuser.social_path"   class="rounded-circle user_img_msg">
                                <img v-else :src="'/images/avatar/'+authuser.image"   class="rounded-circle user_img_msg">
                            </div>
                        </div>
                   </div>
                   
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <!-- <div class="input-group-append">
                            <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                        </div> -->
                        <input name="" class="form-control type_msg" placeholder="Type your message..." v-model="message">
                            <span @click="sendMessage" class="input-group-text send_btn"><i class="fas fa-location-arrow" ></i></span>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import ApiServices from '../../../services/api.services';
import axios from 'axios';
import Pusher from 'pusher-js';
export default {
    name:"MessageContent",
    props: [
    "allusers",
    "authuser",
    "turn_url",
    "turn_username",
    "turn_credential",
  ],
  data(){
      return {
          message:null,
          user_2:null,
          messages:[],
          services:new ApiServices(),
          allMessages:[],
          user:[],
      }
  },
  
    methods:{
        sendMessage(){
            if(!this.message){
                return alert("Please enter message");
            }
            // this.allMessages.push(this.message);

            const formData = new FormData();
            formData.append("content",this.message);
            formData.append("user_1",this.authuser.id);
            formData.append("user_2",this.user_2);
            axios.post("/users/message",formData)
            .then(response => {
                console.log(response);
                this.message =null;
                this.fetchMessage();
            })


        },
        fetchMessage(){
            axios.get("/users/message/"+this.authuser.id+"/"+this.user_2)
            .then(response => {
                this.allMessages = response.data.message;
                this.user = response.data.user;
            })
        },

    },
    mounted(){
        // Pusher.logToConsole = true;
		// var pusher = new Pusher('74075fba8f6c86cdac5f', {
		// cluster: 'ap2'
		// });

		// var channel = pusher.subscribe('message-sent');
		// channel.bind('MessageSent', function(data) {
		// console.log("This is for you "+data);
		// });
         Echo.private("message-sent")
        .listen("MessageSent",(e)=>{
            this.allMessages.push(e.message);
            window.scrollBy(0,99999);
        });
    },
    
    created(){
        this.user_2 = this.$route.params.id;
        this.fetchMessage();
    }

}
</script>

<style>
.chat{
			margin-top: auto;
			margin-bottom: auto;
		}
		.card{
			height: 500px;
			border-radius: 15px !important;
		}
		.contacts_body{
			padding:  0.75rem 0 !important;
			overflow-y: auto;
			white-space: nowrap;
		}
		.msg_card_body{
			overflow-y: auto;
		}
		.card-header{
			border-radius: 15px 15px 0 0 !important;
			border-bottom: 0 !important;
		}
	 .card-footer{
		border-radius: 0 0 15px 15px !important;
			border-top: 0 !important;
	}
		.container{
			align-content: center;
		}
		.search{
			border-radius: 15px 0 0 15px !important;
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color:white !important;
		}
		.search:focus{
		     box-shadow:none !important;
           outline:0px !important;
		}
		.type_msg{
			border:0 !important;
			overflow-y: auto;
		}
			.type_msg:focus{
		     box-shadow:none !important;
           outline:0px !important;
		}
		.attach_btn{
	border-radius: 15px 0 0 15px !important;
	background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
		}
		.send_btn{
            border-radius: 0 15px 15px 0 !important;
            background-color: rgba(0,0,0,0.3) !important;
            border:0 !important;
            color: white !important;
            cursor: pointer;
		}
		.search_btn{
			border-radius: 0 15px 15px 0 !important;
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
		}
		.contacts{
			list-style: none;
			padding: 0;
		}
		.contacts li{
			width: 100% !important;
			padding: 5px 10px;
			margin-bottom: 15px !important;
		}
	.active{
			background-color: rgba(0,0,0,0.3);
	}
		.user_img{
			height: 70px;
			width: 70px;
			border:1.5px solid #f5f6fa;
		
		}
		.user_img_msg{
			height: 40px;
			width: 40px;
			border:1.5px solid #f5f6fa;
		
		}
	.img_cont{
			position: relative;
			height: 70px;
			width: 70px;
	}
	.img_cont_msg{
			height: 40px;
			width: 40px;
	}
	.online_icon{
		position: absolute;
		height: 15px;
		width:15px;
		background-color: #4cd137;
		border-radius: 50%;
		bottom: 0.2em;
		right: 0.4em;
		border:1.5px solid white;
	}
	.offline{
		background-color: #c23616 !important;
	}
	.user_info{
		margin-top: auto;
		margin-bottom: auto;
		margin-left: 15px;
	}
	.user_info span{
		font-size: 20px;
		color: white;
	}
	.user_info p{
	font-size: 10px;
	color: rgba(255,255,255,0.6);
	}
	.video_cam{
		margin-left: 50px;
		margin-top: 5px;
	}
	.video_cam span{
		color: white;
		font-size: 20px;
		cursor: pointer;
		margin-right: 20px;
	}
	.msg_cotainer{
		margin-top: auto;
		margin-bottom: auto;
		margin-left: 10px;
		border-radius: 25px;
		background-color: #82ccdd;
		padding: 10px;
		position: relative;
	}
	.msg_cotainer_send{
		margin-top: auto;
		margin-bottom: auto;
		margin-right: 10px;
		border-radius: 25px;
		background-color: #78e08f;
		padding: 10px;
		position: relative;
	}
	.msg_time{
		position: absolute;
		left: 0;
		bottom: -15px;
		color: rgba(255,255,255,0.5);
		font-size: 10px;
	}
	.msg_time_send{
		position: absolute;
		right:0;
		bottom: -15px;
		color: rgba(255,255,255,0.5);
		font-size: 10px;
	}
	.msg_head{
		position: relative;
	}
	#action_menu_btn{
		position: absolute;
		right: 10px;
		top: 10px;
		color: white;
		cursor: pointer;
		font-size: 20px;
	}
	.action_menu{
		z-index: 1;
		position: absolute;
		padding: 15px 0;
		background-color: rgba(0,0,0,0.5);
		color: white;
		border-radius: 15px;
		top: 30px;
		right: 15px;
		display: none;
	}
	.action_menu ul{
		list-style: none;
		padding: 0;
	margin: 0;
	}
	.action_menu ul li{
		width: 100%;
		padding: 10px 15px;
		margin-bottom: 5px;
	}
	.action_menu ul li i{
		padding-right: 10px;
	
	}
	.action_menu ul li:hover{
		cursor: pointer;
		background-color: rgba(0,0,0,0.2);
	}
	@media(max-width: 576px){
	.contacts_card{
		margin-bottom: 15px !important;
	}
    }
    .fa-location-arrow{
        margin-top: 15px;
    }
</style>