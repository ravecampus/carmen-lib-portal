<template>
    <main class="main">
    <section class="section-agents section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap pb-2">
                        <div class="title-box">
                        <h2 class="title-a ">School Profile</h2>
                        <h4 >{{post.title }}</h4>
                        <p>{{ post.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </section>
      <section class="intro-single pt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="title-single-box shadow p-4">
                    <h3 class="text-secondary">History</h3>
                    <span class="color-text-a ">{{ post.history }}</span>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="title-single-box shadow">
                    <h3 class="text-secondary">Mission</h3>
                    <span class="color-text-a">{{ post.mission }}</span>
                    <h3 class="text-secondary">Vision</h3>
                    <span class="color-text-a">{{ post.vision }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="title-single-box shadow">
                    <h3 class="text-secondary">Rules and Regulations</h3>
                    <span class="color-text-a">{{ post.rules_regulation }}</span>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- End Intro Single-->
        
    </main>
</template>

<script>
export default {
    data(){
        return{
            post:{}
        }
    },
    methods:{
        loadProfile(){
            this.$axios.get("sanctum/csrf-cookie").then(response=>{
                this.$axios.get('api/lib-profile/'+ 1).then(res=>{
                   this.post = res.data;
                });
            });
        },
    },
    mounted() {
        this.loadProfile();
    },
}
</script>

<style>

</style>
