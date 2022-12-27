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
  <main class="main">
     <section class="section-news section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
              <div class="card shadow">
                <div class="card-body text-center text-secondary">
                          <h1 class="text-secondary">LIBRARY PORTAL OF CARMEN ACADEMY</h1>
                          <h4 class="text-secondary">CARMEN, COTABATO</h4>
                      
                      <div class="d-flex justify-content-center mb-4">
                        
                        <img class="w-50" :src="'../img/logo.jpg'" />
                      </div>
                </div>
              </div>
          </div>
        </div>
      </div>
     </section>
  </main>

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
          }
             
  },
}
</script>

<style>

</style>
