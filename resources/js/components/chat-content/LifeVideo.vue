<template>
  <div class="container row">
    <div class="col-md-3">
      
    </div>
    <div class="col-md-7">
      <router-view :viewtext="viewtext" :user_id="authuser.id"></router-view>

      <div v-show="showdiv">
        <div class="card" style="height: 100px; width: 100%;">
        <button class="btn btn-success mp mt-4" @click="placeVideoCall(authuser.id,authuser.name)" title="Click to life">
          <i class="fas fa-video"></i>
        </button>
      </div>
      <div class="card" style="height: 400px; width: 100%;">
        
        <div id="set-payment" class="uk-flex-top " uk-modal>
          <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-width-large ">
              
            <div  style="text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 20px;padding-top: 20px;">
                You don't have enough coins. Please buy
            </div>
            <a >
                <div class="uk-modal-close bye-button" @click="byeCoin()"  style="text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 10px;padding-top: 10px;">
                        Bye    

                </div>
            </a>
              
            <a>
              <div class="uk-modal-close" style="text-align: center; padding-top: 20px;">
                  Cancel
              </div>
            </a>
              
        </div>
      </div>
        <div class="card-image" >
          <video
            ref="userVideo"
            muted
            playsinline
            autoplay
            class="cursor-pointer"
            
          />
          <button type="button" class="btn btn-danger mp" @click="endCall" v-show="showendcall">
                      Stop Life
                    </button>
        
        </div>
        <div class="buttons coin-div">
            <a style="color:blue;" class="post-action" @click="setGift(10)">
              <span>10$</span>
              <i class="fas fa-gift"></i>
            </a>
            <a style="color:red; padding-left:10%;" class="post-action" @click="setGift(8)">
              <span>8$</span>
              <i class="fas fa-heart mp" ></i>
            </a>
            <a style="color: rgb(51, 255, 0); padding-left:10%;" class="post-action" @click="setGift(5)">
              <span>5$</span>
              <img src="/images/gift-image.jpeg" class="gift-image">
            </a>
        </div>
      </div>
      <div class="card" style="height: 400px; width: 100%;">
        <div class="card-image" >
          <video
            ref="partnerVideo"
            muted
            playsinline
            autoplay
            class="cursor-pointer"
            
          />
        
        </div>
        <div class="buttons coin-div">
            <a style="color:blue;" class="post-action" @click="setGift(10)">
              <span>10$</span>
              <i class="fas fa-gift"></i>
            </a>
            <a style="color:red; padding-left:10%;" class="post-action" @click="setGift(8)">
              <span>8$</span>
              <i class="fas fa-heart mp" ></i>
            </a>
            <a style="color: rgb(51, 255, 0); padding-left:10%;" class="post-action" @click="setGift(5)">
              <span>5$</span>
              <img src="/images/gift-image.jpeg" class="gift-image">
            </a>
        </div>
        
      </div>
      <!-- Incoming Call  -->
      <div class="row" v-if="incomingCallDialog">
        <div class="col">
          <p>
            Incoming life From <strong>{{ callerDetails.name }}</strong>
          </p>
          <div class="btn-group" role="group">
            <button
              type="button"
              class="btn btn-danger"
              data-dismiss="modal"
              @click="declineCall"
            >
              Decline
            </button>
            <a href="#modal-call" uk-toggle
              type="button"
              class="btn btn-success ml-5"
              @click="acceptCall"
            >
              View
            </a>
          </div>
        </div>
      </div>
      <!-- End of Incoming Call  -->
      </div>
    </div>
    <div class="col-md-2"></div>
  </div>
</template>

<script>
import Peer from "simple-peer";
import { getPermissions } from "../../helper";
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export default {
name:"LifeVideo",
props: [
    "allusers",
    "authuser",
    "turn_url",
    
  ],

  data() {
    return {
      isFocusMyself: true,
      callPlaced: false,
      callPartner: null,
      mutedAudio: false,
      mutedVideo: false,
      videoCallParams: {
        users: [],
        stream: null,
        receivingCall: false,
        caller: null,
        callerSignal: null,
        callAccepted: false,
        channel: null,
        peer1: null,
        peer2: null,
      },
      allMessages:[],
      user:[],
      showendcall:false,
      video: '',
      uploadPercentage: 0,
      showdiv:true,
      viewtext:""
    };
  },
  created(){
    this.checkGift(1);
  },
  mounted() {
    
     Echo.private("message-sent-"+this.authuser.id+"-"+this.user.id)
        .listen("MessageSent",(e)=>{
            alert("Hi");
		});
    this.initializeChannel(); // this initializes laravel echo
    this.initializeCallListeners(); // subscribes to video presence channel and listens to video events
 
  },
  computed: {
    incomingCallDialog() {
      if (
        this.videoCallParams.receivingCall &&
        this.videoCallParams.caller !== this.authuser.id
      ) {
        return true;
      }
      return false;
    },

    callerDetails() {
      if (
        this.videoCallParams.caller &&
        this.videoCallParams.caller !== this.authuser.id
      ) {
        const incomingCaller = this.allusers.filter(
          (user) => user.id === this.videoCallParams.caller
        );

        return {
          id: this.videoCallParams.caller,
          name: `${incomingCaller[0].name}`,
        };
      }
      return null;
    },
  },
  methods:{
    
    checkGift(amount){
      var formData = new FormData();
      formData.append("user_id",this.authuser.id);
      formData.append("amount",amount);
      axios.post("/check-coin",formData)
      .then((response) => {
        if(response.data.status){
          if(response.data.message >= amount){
            return true;
          }
          else{
              var modal = UIkit.modal("#set-payment");
              modal.show();
          }
        }
        else{
          var modal = UIkit.modal("#set-payment");
          modal.show(); 
          
        }
      })
      .catch((error)=>{
        console(error);
      });
    },

    byeCoin(){
      this.showdiv=false;
      this.$router.push("/bye-coin/"+this.authuser.id)
      .catch((er)=>{})
      ;
    },

    setGift(amount){
      var formData = new FormData();
      formData.append("user_id",this.authuser.id);
      formData.append("amount",amount);
      axios.post("/check-coin",formData)
      .then((response) => {
        if(response.data.status){
          if(response.data.message >= amount){
            axios.post("/set-gift",formData)
            .then((response)=>{
              if(response.data.status){
                alert("Thanks");
              }
            })
            .catch((err)=>{

            })
          }
          else{
              var modal = UIkit.modal("#set-payment");
              modal.show();
          }
        }
        else{
          var modal = UIkit.modal("#set-payment");
          modal.show(); 
          
        }
      })
      .catch((error)=>{
        console(error);
      });
    },

    initializeChannel() {
      this.videoCallParams.channel = window.Echo.join("life-channel");
    },

    getMediaPermission() {
      return getPermissions()
        .then((stream) => {
          this.videoCallParams.stream = stream;
          if (this.$refs.userVideo) {
            this.$refs.userVideo.srcObject = stream;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    initializeCallListeners() {
      this.videoCallParams.channel.here((users) => {
        this.videoCallParams.users = users;
      });

      this.videoCallParams.channel.joining((user) => {
        // check user availability
        const joiningUserIndex = this.videoCallParams.users.findIndex(
          (data) => data.id === user.id
        );
        if (joiningUserIndex < 0) {
          this.videoCallParams.users.push(user);
        }
      });

      this.videoCallParams.channel.leaving((user) => {
        const leavingUserIndex = this.videoCallParams.users.findIndex(
          (data) => data.id === user.id
        );
        this.videoCallParams.users.splice(leavingUserIndex, 1);
      });
      // listen to incomming call
      this.videoCallParams.channel.listen("UserLifeEvent", ({ data }) => {
        alert("hi");
        if (data.type === "incomingCall") {
          // add a new line to the sdp to take care of error
          const updatedSignal = {
            ...data.signalData,
            sdp: `${data.signalData.sdp}\n`,
          };

          this.videoCallParams.receivingCall = true;
          this.videoCallParams.caller = data.from;
          this.videoCallParams.callerSignal = updatedSignal;
        }
      });
    },
    async placeVideoCall(id, name) {
      this.callPlaced = true;
      this.callPartner = name;
      await this.getMediaPermission();
      this.videoCallParams.peer1 = new Peer({
        initiator: true,
        trickle: false,
        stream: this.videoCallParams.stream,
       
      });
      this.showendcall = true;

      this.videoCallParams.peer1.on("signal", (data) => {
        // send user call signal
        axios
          .post("/video/life-chat", {
            signal_data: data,
            from: this.authuser.id,
          })
          .then(() => {})
          .catch((error) => {
            console.log("error"+error);
          });
      });

      this.videoCallParams.peer1.on("stream", (stream) => {
        console.log("call streaming");
        if (this.$refs.partnerVideo) {
          this.$refs.partnerVideo.srcObject = stream;
        }
      });

      this.videoCallParams.peer1.on("connect", () => {
        console.log("peer connected");
      });

      this.videoCallParams.peer1.on("error", (err) => {
        console.log("Peer "+err);
      });

      this.videoCallParams.peer1.on("close", () => {
        console.log("call closed caller");
      });

      this.videoCallParams.channel.listen("UserLifeEvent", ({ data }) => {
        if (data.type === "callAccepted") {
          if (data.signal.renegotiate) {
            console.log("renegotating");
          }
          if (data.signal.sdp) {
            this.videoCallParams.callAccepted = true;
            const updatedSignal = {
              ...data.signal,
              sdp: `${data.signal.sdp}\n`,
            };
            this.videoCallParams.peer1.signal(updatedSignal);
          }
        }
      });
    },

    async acceptCall() {
      this.callPlaced = true;
      this.videoCallParams.callAccepted = true;
      this.videoCallParams.peer2 = new Peer({
        initiator: false,
        trickle: false,
        stream: this.videoCallParams.stream,
       
      });
      this.videoCallParams.receivingCall = false;
      this.videoCallParams.peer2.on("signal", (data) => {
        
      });

      this.videoCallParams.peer2.on("stream", (stream) => {
        this.videoCallParams.callAccepted = true;
        this.$refs.partnerVideo.srcObject = stream;
      });

      this.videoCallParams.peer2.on("connect", () => {
        console.log("peer connected");
        this.videoCallParams.callAccepted = true;
      });

      this.videoCallParams.peer2.on("error", (err) => {
        console.log(err);
      });

      this.videoCallParams.peer2.on("close", () => {
        console.log("call closed accepter");
      });

      this.videoCallParams.peer2.signal(this.videoCallParams.callerSignal);
    },
    toggleCameraArea() {
      if (this.videoCallParams.callAccepted) {
        this.isFocusMyself = !this.isFocusMyself;
      }
    },
    getUserOnlineStatus(id) {
      const onlineUserIndex = this.videoCallParams.users.findIndex(
        (data) => data.id === id
      );
      if (onlineUserIndex < 0) {
        return "Offline";
      }
      return "Online";
    },
    declineCall() {
      this.videoCallParams.receivingCall = false;
    },

    toggleMuteAudio() {
      if (this.mutedAudio) {
        this.$refs.userVideo.srcObject.getAudioTracks()[0].enabled = true;
        this.mutedAudio = false;
      } else {
        this.$refs.userVideo.srcObject.getAudioTracks()[0].enabled = false;
        this.mutedAudio = true;
      }
    },

    toggleMuteVideo() {
      if (this.mutedVideo) {
        this.$refs.userVideo.srcObject.getVideoTracks()[0].enabled = true;
        this.mutedVideo = false;
      } else {
        this.$refs.userVideo.srcObject.getVideoTracks()[0].enabled = false;
        this.mutedVideo = true;
      }
    },

    stopStreamedVideo(videoElem) {
      const stream = videoElem.srcObject;
      const tracks = stream.getTracks();
      tracks.forEach((track) => {
        track.stop();
      });
      videoElem.srcObject = null;
    },
    endCall() {
      this.showendcall = false;
      // if video or audio is muted, enable it so that the stopStreamedVideo method will work
      if (!this.mutedVideo) this.toggleMuteVideo();
      if (!this.mutedAudio) this.toggleMuteAudio();
      
      this.stopStreamedVideo(this.$refs.userVideo);
      if (this.authuser.id === this.videoCallParams.caller) {
        this.videoCallParams.peer1.destroy();
      } else {
        this.videoCallParams.peer2.destroy();
      }
      this.videoCallParams.channel.pusher.channels.channels[
        "presence-life-channel"
      ].disconnect();

      setTimeout(() => {
        this.callPlaced = false;
      }, 3000);
    },
  }
}
</script>

<style>
.cursor-pointer{
  width: 100%;
  height: 70%;
}
.coin-div{
  margin-left: 35%;
}
.gift-image{
  width: 35px;
}
.bye-button{
background-color: blue;
border-radius: 50px;
color: white;
}

</style>