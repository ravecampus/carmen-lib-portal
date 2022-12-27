<template>
<div>
  <!-- ======= Header/Navbar ======= -->
  <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top d-print-none">
    <div class="container">
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <router-link class="navbar-brand text-brand" :to="{name:'admindashboard'}">
          Admin<span class="color-b">istrator</span>
          <div class="sub-b"><p>Asia International College Of Science And Technology</p></div>
      </router-link>
      <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
        <ul class="navbar-nav">

          <li class="nav-item">
            <router-link class="nav-link" :to="{name:'admindashboard'}">Dashboard</router-link>
          </li>
          

          <li class="nav-item">
            <router-link class="nav-link " :to="{name:'adminlibprofile'}">Profile</router-link>
          </li>

          <li class="nav-item">
            <router-link class="nav-link " :to="{name:'adminacademic'}">Academics</router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">E. Resources</a>
            <div class="dropdown-menu">
              <router-link class="dropdown-item" :to="{name:'adminbook'}" >Books</router-link>
              <router-link class="dropdown-item" :to="{name:'adminjournal'}">Journals</router-link>
              <router-link class="dropdown-item " :to="{name:'adminmagazine'}" >Magazine</router-link>
            </div>
          </li>

          <li class="nav-item">
            <router-link class="nav-link " :to="{name:'adminservice'}">Services</router-link>
          </li>

           <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
            <div class="dropdown-menu">
              <p class="p-2"><span class="fa fa-user"></span>  {{ user.first_name+" "+user.last_name }}</p>
              <hr>
              <router-link class="dropdown-item" :to="{name:'adminuser'}" >Administrator</router-link>
              <router-link class="dropdown-item" :to="{name:'adminreport'}">Report</router-link>
              <a class="dropdown-item " href="#" @click="logout()">Log out</a>
            </div>
          </li>
        </ul>
      </div>

  

    </div>
  </nav><!-- End Header/Navbar -->
 <flashmessage :message="message" :status="status"></flashmessage>
  <router-view @show="flashMessage"></router-view>

   <footer class="mt-5 d-print-none">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="nav-footer">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="#">Asia International College Of Science And Technology</a>
              </li>
            </ul>
          </nav>
          <div class="copyright-footer">
            <p class="copyright color-text-a">
              &copy; Copyright
              <span class="color-a">Carmen Academy</span> All Rights Reserved.
            </p>
          </div>
          <div class="credits">
          
            <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
          </div>
        </div>
      </div>
    </div>
  </footer>

</div>
</template>

<script>
import FlashMessage from '../page/FlashMessage.vue';
export default {
    components:{
        flashmessage: FlashMessage
    },
    data(){
        return{
          message:'',
          status:0,
          user:{},
        }
    },
    methods: {
        logout(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } 
                    })
                    .catch(function (error) {
                     
                    });
            })
        },
        flashMessage(data){
             this.showMessage(data)
        },
        showMessage(data){
            this.message = data.message;
            if(data.status == 1){
                this.status = 'alert-success';
            }else if(data.status == 2){
                this.status = 'alert-warning';
            }else if(data.status == 3){
                this.status = 'alert-danger';
            }else if(data.status == 4){
                this.status = 'alert-secondary';
            }else if(data.status == 5){
                this.status = 'alert-dark';
            }else if(data.status == 6){
                this.status = 'alert-light';
            }else if(data.status == 7){
                this.status = 'alert-primary';
            }
            $('.fm-body').show();
            setTimeout(() => {
                $('.fm-body').fadeOut("slow");
            }, 500);
      },
    },
    mounted() {
       if(window.Laravel.isLoggedin){
            this.user = window.Laravel.user;
            this.auth = true;
        }

        this.title = window.Title.app_name;
    },
}
</script>

<style>

</style>
