<template>
    <main class="main">
        <section class="section-agents section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap pb-2">
                        <div class="title-box">
                        <h2 class="title-a ">Contact</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
           <div class="row">

                <div class="col-md-7 mb-5">
                    <form method="post" role="form" class="php-email-form">
                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="message" v-model="post.message" class="form-control" cols="45" rows="4" placeholder="Message" required></textarea>
                            <span class="errors-material" v-if="errors.message">{{errors.message[0]}}</span>
                        </div>
                        </div>
                        <div class="col-md-12 my-3">
                        <div class="mb-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        </div>

                        <div class="col-md-12 text-center">
                        <button :disabled="btndis" type="button" @click="saveComment()" class="btn btn-a">{{btncap}}</button>
                        </div>
                    </div>
                    </form>
                </div>

                <hr>
               <div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1">
                    <div class="title-box-d">
                    <h3 class="title-d">Comments </h3>
                    </div>
                    <div class="box-comments">
                    <ul class="list-comments" v-for="(list,indx) in comments" :key="indx">
                        <li>
                        <div class="comment-avatar">
                            <img :src="'../img/user.jpg'" alt="">
                        </div>
                        <div class="comment-details">
                            <h4 class="comment-author">{{ list.first_name }},  {{ list.last_name }}</h4>
                            <span>{{ formatDate(list.created_at)}} </span>
                            <p class="comment-description">
                                {{ list.message }}
                            </p>
                            <a href="#" @click="reply(list)">Reply</a>
                        </div>
                        </li>

                        <li class="comment-children" v-for="(lst,idx) in list.replies" :key="idx">
                        <div class="comment-avatar">
                             <img :src="'../img/reply.jpg'" alt="">
                        </div>
                        <div class="comment-details">
                            <h4 class="comment-author">{{ lst.user.first_name  }}, {{ lst.user.last_name  }}</h4>
                            <span>{{formatDate(lst.created_at) }}</span>
                            <p class="comment-description">
                           {{ lst.message }}
                            </p>
                            <!-- <a href="3">Reply</a> -->
                        </div>
                        </li>
                        
                    </ul>
                    </div>
               </div>
           </div>
        </div>


        <div class="modal fade reply">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6>Reply to <strong>{{ this.message.first_name }}</strong></h6>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 php-email-form">
                            <div class="form-group">
                                <textarea class="form-control form-control-a" v-model="message.message_" rows="5" placeholder="Message..."></textarea>
                                <span class="errors-material" v-if="errors.message_">{{errors.message_[0]}}</span>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <div class="btn-group">
                            <button type="button" @click="replyPost(message)" class="btn btn-b-n">Send</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

      </section> 
    </main>
</template>

<script>


export default {
      data(){
        return{
            message:{},
            users:[],
            post:{},
            btncap:"Send Message",
            errors:[],
            comments:[],
            btndis:false,
        }
    },
    methods: {
        saveComment(){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.btncap = "Sending";
                this.btndis = true;
                this.$axios.post("api/comment", this.post).then(res=>{
                    this.$emit('show',{'message':'Message sent!', 'status':4});
                    this.btncap = "Send Message";
                    this.post ={};
                    this.errors = [];
                    this.listComment();
                    this.btndis = false;
                }).catch(err=>{
                    this.btncap = "Send Message";
                    this.btndis = false;
                    this.errors = err.response.data.errors
                });
            });
        },
        listComment(){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.get("api/comment").then(res=>{
                    this.comments = res.data;
                });
            });
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        listUser(){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.get("api/user-list").then(res=>{
                    this.users = res.data;
                });
            });
        },
        reply(data){
            this.message = data;
            $('.reply').modal('show');
        },
        replyPost(message){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                    this.$axios.post("api/reply", message).then(res=>{
                        this.$emit('show',{'message':'Reply has been sent!', 'status':4});
                        this.errors = [];
                        this.message = {};
                        this. listComment();
                        $('.reply').modal('hide');
                    }).catch(err=>{
                        this.errors = err.response.data.errors
                    });
                });
        },
        extractUser(id){
            let ret = "";
            this.users.forEach(val => {
                if(id == val.id){
                    ret = val.first_name+" "+val.last_name;
                }
            });
            return ret;
        }
           
    },
    mounted(){
        this.listComment();
        this.listUser();
    }
}
</script>

<style>
</style>