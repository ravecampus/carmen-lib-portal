<template>
    <main class="main">
    <section class="section-news">
      <div class="container">
        <div class="row">
          <!-- <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Latest Updates</h2>
              </div>
              <div class="title-link">
              
              </div>
            </div>
          </div> -->
            <div class="col-md-6 offset-md-3">
               <div class="col-lg-12">       
                    <div class="p-5">
                        <div class="text-center">
                            <router-link :to="{name:'home'}"><h1 class="h4 text-brand">Carmen<span class="color-b">  Academy</span></h1></router-link>
                            <p >Asia International College Of Science And Technology</p>
                            <h3 class="h4 text-gray-900 mb-4">Welcome Back!</h3>
                        </div>
                        <div class="alert alert-danger p-0" v-if="errors.main">
                            <div class="alert errors-material m-0">
                                <div v-if="errors.main"><strong>*</strong>{{errors.main[0]}}</div>
                            </div>
                        </div>
                        <form class="php-email-form">
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <input type="email"  @keyup.enter="login" v-model="post.email" class="form-control form-control-a"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Enter Email Address...">
                                                <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                                    </div>
                                </div>
                                <div class="col-md-12 mb3">
                                    <div class="form-group">
                                        <input type="password"  @keyup.enter="login" v-model="post.password" class="form-control  form-control-a"
                                            id="exampleInputPassword" placeholder="Enter Password...">
                                                <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                    </div>
                                </div>
                                <!-- <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Remember
                                            Me</label>
                                    </div>
                                </div>   -->
                            </div>
                            <button type="button" :disabled="btndis" @click="login()" class="btn btn-b-n">
                                {{btn}}
                            </button>
                            
                        </form>
                        <hr>
                        <!-- <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div> -->
                        <div class="text-center">
                            <router-link class="small" :to="{name:'register'}">Create an Account!</router-link>
                        </div>
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
    return {
            title:"",
            post:{},
            errors:[],
            btn:'Login',
            btndis:false
        }
    },
    methods:{
        login(){
            let route = this.$route.query;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btndis = true
                this.btn = "Logging..."
                this.$axios.post('api/login', this.post).then(res=>{
                    this.btndis = false
                    this.btn = "Login"
                    // window.location.href = "/"
                    if(route.redir == undefined){
                        window.location.href = "/";
                    }
                    // else{
                    //     window.location.href = route.redir;
                    // }
                    this.post = {};
                }).catch(err=>{
                    this.btndis = false
                    this.btn = 'Login'
                    this.errors = err.response.data.errors
                });
            });
        }
    },
    mounted() {
        this.title = window.Title.app_name;
    },
}
</script>

<style>

</style>
