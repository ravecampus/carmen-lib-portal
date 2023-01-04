<template>
    <main id="main">
    <section class="section-services section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <div class="title-wrap d-flex justify-content-center">
                    <div class="title-box">
                    <h2 class="title-a ">Library Profile and History</h2>
                    <h6 >Set up library information</h6>
                    </div>
                </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-8 offset-md-2 mb-5">
                <form role="form" class="php-email-form">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <div class="form-group">
                        <label>Title</label>
                        <input type="text" v-model="post.title" class="form-control form-control-lg form-control-a" placeholder="Title">
                      </div>
                    </div>
                     <div class="col-md-12 mb-3">
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" v-model="post.description" class="form-control form-control-lg form-control-a" placeholder="Description">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>School History</label>
                        <textarea v-model="post.history" class="form-control mb-3" cols="45" rows="8" placeholder="School History"></textarea>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Mission</label>
                        <textarea v-model="post.mission" class="form-control mb-3" cols="45" rows="4" placeholder="Mission"></textarea>
                      </div>
                    </div>
                     <div class="col-md-12">
                      <div class="form-group">
                        <label>Vission</label>
                        <textarea v-model="post.vision" class="form-control mb-3" cols="45" rows="4" placeholder="Vission"></textarea>
                      </div>
                    </div>
                     <div class="col-md-12">
                      <div class="form-group">
                        <label>Rules and Regulations</label>
                        <textarea name="message" v-model="post.rules_regulation" class="form-control mb-3" cols="45" rows="4" placeholder="Rules and Regulation"></textarea>
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
                      <button type="button" :disabled="btndis" @click="saveProfile()" class="btn btn-a">{{ btncap }}</button>
                    </div>
                  </div>
                </form>
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
            post:{},
            btncap:"Save",
            btndis: false,
        }
    },
    methods: {
        loadProfile(){
            this.$axios.get("sanctum/csrf-cookie").then(response=>{
                this.$axios.get('api/lib-profile/'+ 1).then(res=>{
                   this.post = res.data;
                });
            });
        },
        saveProfile(){
            if(this.post.id > 0){
                this.$axios.get("sanctum/csrf-cookie").then(response=>{
                    this.btncap ="Saving...";
                    this.btndis = true;
                    this.$axios.put('api/lib-profile/'+ 1, this.post).then(res=>{
                        this.$emit('show',{'message':'Library Profile has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.btndis = false;
                        this.loadProfile();
                    }).catch(err=>{
                        this.btndis = false;
                        this.btncap = "Save";
                    });
                });
            }else{
                this.$axios.get("sanctum/csrf-cookie").then(response=>{
                    this.btncap ="Saving...";
                    this.btndis = true;
                    this.$axios.post('api/lib-profile/', this.post).then(res=>{
                        this.$emit('show',{'message':'Library Profile has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.btndis = false;
                        this.loadProfile();
                    }).catch(err=>{
                        this.btndis = false;
                        this.btncap = "Save";
                    });
                }); 
            }
            
        }
    },
    mounted() {
        this.loadProfile()
    },
}
</script>

<style>

</style>
