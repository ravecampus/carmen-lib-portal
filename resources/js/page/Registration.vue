<template>
    <main class="main">
    <section class="section-news">
      <div class="container">
        <div class="row">
          
            <div class="col-md-8 offset-md-2">
               <div class="col-lg-12">       
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-brand">Carmen<span class="color-b">  Academy</span></h1>
                            <p >Asia International College Of Science And Technology</p>
                            <h3 class="h4 text-gray-900 mb-4">Create an Account!</h3>
                        </div>
                        <div class="alert alert-danger p-0" v-if="errors.main">
                            <div class="alert errors-material m-0">
                                <div v-if="errors.main"><strong>*</strong>{{errors.main[0]}}</div>
                            </div>
                        </div>
                           <form class="php-email-form">
                                <div class="form-group row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="post.first_name" class="form-control form-control-a"
                                            placeholder="First Name">
                                     <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" v-model="post.last_name" class="form-control form-control-a"
                                            placeholder="Last Name">
                                     <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>

                                    </div>
                                </div>
                                 <div class="form-group mb-3 row">
                                     <div class="col-md-4">
                                        <input type="radio" v-model="post.role" :value="0"> &nbsp;
                                        <label>Student</label>
                                     </div>
                                     <div class="col-md-4">
                                        <input type="radio" class="ml-5" v-model="post.role" :value="1"> &nbsp;
                                        <label >Faculty</label>
                                     </div>
                                     <div class="col-md-4">
                                         <input type="radio" class="ml-5"  v-model="post.role" :value="2"> &nbsp;
                                        <label>Visitor</label>
                                     </div>   
                                    <div>
                                        <span class="errors-material" v-if="errors.role">{{errors.role[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="email" v-model="post.email" class="form-control form-control-a"
                                        placeholder="Email Address">
                                     <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" v-model="post.password" class="form-control form-control-a"
                                             placeholder="Password">
                                        <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" v-model="post.password_confirmation" class="form-control form-control-a"
                                            placeholder="Password Confirmation">
                                        <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>

                                    </div>
                                </div>
                               
                                <button type="button" :disabled="btndis" @click="register()" class="btn btn-b-n btn-block">
                                    {{ btn }}
                                </button>
                            </form>
                        <hr>
                        <div class="text-center">
                            <router-link class="small" :to="{name:'login'}">Already have an account? Login!</router-link>
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
        return{
            title:"",
            post:{},
            errors:[],
            btn:'Register Account',
            btndis: false,
        }
    },
    methods: {
         register(){
            this.$axios.get('sanctum/csrf-cookie').then(res=>{
                this.btn = 'Processing...'
                this.btndis = true
                this.$axios.post('api/register', this.post).then(res=>{
                    this.btndis = false
                    this.btn = 'Register Account'
                    this.$router.push({name:'login'});
                    this.post = {}
                }).catch(err=>{
                    this.btndis = false
                    this.btn = 'Register Account'
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
