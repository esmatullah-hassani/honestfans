<template>
  <div class="container row"  >
      <div class="col-md-2"></div>
    
      <div class="col-md-4" style="overflow-y: scroll;max-height:500px; ">
          <div class="row" style="display: inline-block; margin-top: 10px; width: 100%; " v-for="user in others" v-bind:key="user.id">
                
                    <div class="row">
                        <div class="col-md-10">
                            <router-link to="" tabindex="0" style="width: 56px; height: 56px;">
                   
                                <img v-if="user.social_path!=null" alt="profile picture" class="circle-user-image-32" data-testid="user-avatar" draggable="false" :src="user.social_path">
                            
                            <img v-else alt="profile picture" class="circle-user-image-32" data-testid="user-avatar" draggable="false" src="">
                            
                            </router-link>
                            <router-link to="{user.id}" class="margin-left-10 color-dark" >
                            <span v-if="user.display_name == null">{{user.name}}</span>
                            <span v-else>{{user.display_name}}</span>
                            
                            </router-link>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="mp btn-link" @click="userVideoCall(user.id)">
                                <i class="fas fa-video"  ></i>
                            </button>
                        </div>
                    </div>
                    
                    <br>
                 
                    
                
            </div>
      </div>
      <div class="col-md-6" >
          <router-view />
      </div>
  </div>
</template>

<script>
export default {
    props: ['user', 'others', 'pusherKey', 'pusherCluster'],
    name:"ChatContent",
    methods:{
        userVideoCall(id){
            alert(id);
        }
    }

}
</script>

<style>

</style>