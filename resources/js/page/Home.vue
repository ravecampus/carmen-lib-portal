<template>
<div>
  <!-- ======= Header/Navbar ======= -->
  <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container">
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <router-link class="navbar-brand text-brand" :to="{name:'home'}">
       Carmen<span class="color-b">  Academy</span>
          <div class="sub-b"><p>Asia International College Of Science And Technology</p></div>
      </router-link>

      <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
        <ul class="navbar-nav">

          <li class="nav-item">
            <router-link class="nav-link" :to="{name:'login'}">Login</router-link>
          </li>

          <li class="nav-item">
            <router-link class="nav-link " :to="{name:'register'}">Registration</router-link>
          </li>

        </ul>
      </div>

      <!-- <button type="button" class="btn btn-b-n navbar-toggle-box navbar-toggle-box-collapse" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
        <i class="bi bi-search"></i>
      </button> -->

    </div>
  </nav><!-- End Header/Navbar -->

</div>
</template>

<script>
export default {
  data(){
    return{

    }
  },
  methods:{

  },
  mounted() {
    if(window.Laravel.isLoggedin){
            this.user = window.Laravel.user;
            this.auth = true;
        }

          if(window.Laravel.isLoggedin){
                let user = window.Laravel.user;
                if(user.role == 3){
                    this.$router.push({name:'admindashboard'})
                }else if(user.role == 1 || user.role == 0 || user.role == 2){
                     this.$router.push({name:'userhome'})
                }
          }else{
             this.$router.push({name:'login'})
          }
  },
}
</script>

<style>

</style>
