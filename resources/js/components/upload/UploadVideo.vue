<template>
  <div class="card-body is-transparent">
                <!-- Image input -->
                <span style="color:red">{{error}}</span>
                <div class="image-upload">
                    <div class="file is-boxed">
                        <label class="file-label">
                            <input class="file-input" id="video" ref="video" type="file" v-on:change="handleFileUpload()" name="video">
                            <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                <br>
                                <progress max="100" :value.prop="uploadPercentage"></progress>
                                <span class="progress-count" v-show="progrescount">{{uploadPercentage}}%</span>
                                <br>
                                {{upload}}
                            </span>
                            </span>
                        </label>
                    </div>
                </div>


                <!-- Description Input -->
                <div class="field">
                    <label class="label ">Description</label>
                    <div class="control">
                        <textarea name="description"  v-model="discription" class="textarea" placeholder="e.g. Hello world" maxlength="128" required autofocus></textarea>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="field">
                    <div class="control">
                        <button type="submit" v-show="showbutton" v-on:click="submitFile()" class="button is-primary is-fullwidth is-large">
                            Upload
                        </button>
                    </div>
                </div>
        </div>
</template>

<script>
export default {
    name:'UploadVideo',
    data(){
        return{
            video: '',
            uploadPercentage: 0,
            discription:"",
            upload:"Chose a video...",
            error:"",
            showbutton:true,
            progrescount:false,
        }
    },
    methods:{
        /*
            Handles a change on the file upload
        */
        handleFileUpload(){
            this.video = this.$refs.video.files[0];
            this.upload = "Chose a video...";
            this.error = "";
        },

        /*
        Submits the file to the server
        */
        submitFile(){
        if(this.discription != "" && this.video != ""){
            this.upload = "Wait...";
            this.showbutton=false;
            this.progrescount = true;
            this.error = "";
            /*
                Initialize the form data
            */
            let formData = new FormData();

            /*
                Add the form data we need to submit
            */
            formData.append('video', this.video);
            formData.append("description",this.discription);

            /*
                Make the request to the POST /single-file URL
            */
            axios.post('/posts',
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: function( progressEvent ) {
                    this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                }.bind(this)
                }
            )
            .then((data) => {
                if(data.data.status){
                    this.upload = "uploaded successfully";
                    this.discription = "";
                    this.showbutton = true;
                    window.location.href = "/posts/"+data.data.message;
                }
            })
            .catch(function(err){
                console.log(err);
            });
        }
        else{
            this.error = "Something was wrong! try again";
        }
        },
    },
}
</script>

<style>
.progress-count{
    text-align: center;
}
</style>