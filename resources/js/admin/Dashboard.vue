<template>
    
  <main id="main">

    <!-- ======= Services Section ======= -->
    <section class="section-services section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Our Updates</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <input type="text" class="form-control" v-model="tableData.search"  @input="listEvent()" placeholder="Search....">
                    <hr>
                    <button type="button" @click="showAddModal()" class="btn btn-b-n btn-sm"><i class="fa fa-plus"></i> ADD</button>
                    <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                        <tbody v-for="(list, idx) in events" :key="idx">
                            <tr class="tr-shadow">
                                <td>
                                    <img class="img-thumbnail logo-sc" :src="list.image == null ? '../img/logo.jpg' :'../storage/event/'+list.image" />
                                        <div class="">
                                            <a href="#" @click="showUpload(list)" >Edit </a>
                                    </div>
                                </td>
                                <td><strong>{{ list.title }}</strong>
                                </td>
                                <td><span>{{list.description }}</span></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-b-n"  @click="editEvent(list)">
                                            <span class="fa fa-edit"></span>
                                            Edit
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                            
                        </tbody>
                    </data-table>
                    <div class="col-md-12">
                        <div class="pull-right">
                            <pagination :pagination="pagination"
                                @prev="listEvent(pagination.prevPageUrl)"
                                @next="listEvent(pagination.nextPageUrl)"
                                v-show="noData(events)">
                            </pagination>
                        </div>
                    </div>
                    
                </div>
            </div>
          </div>

         <div class="col-md-5">
            <div class="card">
                <div class="card-body">
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
          </div>
         
        
        </div>
      </div>

    
            <div class="modal fade event" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4>Updates</h4>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Title</label>
                                        <input type="text" v-model="post.title" class="form-control form-control-user" placeholder="Enter Title">
                                        <span class="errors-material" v-if="errors.title">{{errors.title[0]}}</span> 
                                    </div>
                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" v-model="post.description" rows="5" placeholder="Description..."></textarea>
                                        <span class="errors-material" v-if="errors.description">{{errors.description[0]}}</span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" @click="saveEvent()" class="btn btn-b-n">{{ btncap }}</button>
                            <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
                        </div>
                    </div>
                </div>
            </div>    
            <div class="modal fade" id="upload-img" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Image</h5>
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> -->
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="logo-view text-center">
                                        <img class="logo-upload" :src="upload.image == null ? '../img/logo.jpg' :'../storage/event/'+upload.image">
                                        <!-- <a href="#" @click="resetLogo()">Reset Default</a> -->
                                    </div>
                                </div>
                                <input type="file" id="uploader" accept="image/gif, image/jpeg" @change="uploadImage" class="hidden">
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" @click="browseImg()" class="btn btn-b-n mt-3">Browse Image</button>
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

    </section><!-- End Services Section -->
  </main><!-- End #main -->

</template>

<script>
import DataTable from '../table/DataTable';
import PaginationVue from '../table/Pagination';

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
    components:{
        Datepicker,
        dataTable:DataTable,
        pagination:PaginationVue
    },
    setup() {
        // In case of a range picker, you'll receive [Date, Date]
        const format = (d) => {
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();

            return  month+ "-" + day  + "-" + year;
        }
        return {
            format,
        }
    },
    data(){
        let sortOrders = {};
        let columns =[
        {label:'Image', name:null},
        {label:'Title', name:'title'},
        {label:'Description', name:'description'},
        {label:'Action ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{
            users:[],
            comments:[],
            message:{},
            upload:{},
            btncap:"Save",
            errors:[],
            post:{},
            events:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            btndis: false,
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                archive:0,
                dir:'desc',
                filter:0,
            },
            pagination:{
                lastPage:'',
                currentPage:'',
                total:'',
                lastPageUrl:'',
                nextPageurl:'',
                prevPageUrl:'',
                from:'',
                to:''
            },
            form: new FormData,
            uploadPercentage_:0,
            showbar:false,
        }
    },
    methods:{
        showAddModal(){
            $('.event').modal('show');
        },
        editEvent(data){
            this.post = data;
            $('.event').modal('show');
        },
        deleteEvent(data){
            this.post = data;
            $('.delete-event').modal('show');
        },
        showUpload(data){
            this.upload = data
            $('#upload-img').modal('show');
        },
        saveEvent(){
            if(this.post.id > 0){
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.btncap = "Saving...";
                this.$axios.put("api/event/"+this.post.id, this.post).then(res=>{
                    this.btncap = "Save";
                    this.$emit('show',{'message':'Event has been modified!', 'status':4});
                    this.post ={};
                    this.errors = [];
                    $('.event').modal('hide');
                    this.listEvent();
                }).catch(err=>{
                    this.btncap = "Save";
                    this.errors = err.response.data.errors
                });
            });
            }else{
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                    this.btncap = "Saving...";
                    this.$axios.post("api/event", this.post).then(res=>{
                        this.$emit('show',{'message':'Event has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.post ={};
                        this.errors = [];
                        $('.event').modal('hide');
                        this.listEvent();
                    }).catch(err=>{
                        this.btncap = "Save";
                        this.errors = err.response.data.errors
                    });
                });
            }
           
        },
        listEvent(url='api/event'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.events = data.data.data;
                        this.configPagination(data.data);
                    }else{
                        this.not_found = true;
                    }
                });
            });
        },
        configPagination(data){
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key){
            if(key != null){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.listEvent();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        confirmDeleteEvent(data){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.delete("api/event/"+data.id).then(res=>{
                    this.$emit('show',{'message':'Event has been deleted!', 'status':4});
                   
                    this.post ={};
                    $('.delete-event').modal('hide');
                    this.listEvent();
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
        browseImg(){
            $('#uploader').click();
        },
        uploadImage(e){
            this.img = e.target.files[0];
            this.uploadLogo();
        },
        uploadLogo(){
            this.form.append('image', this.img);
            this.form.append('id',  this.upload.id);
             const config = {
                header:{'Content-Type':'multipart/form-data'},
                    onUploadProgress:(e)=>{
                        this.uploadPercentage_ = parseInt(Math.round((e.loaded * 100)/ e.total));
                        this.showbar = true;
                    }
                };
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.post('api/event-upload',this.form, config).then(res=>{
                    this.showbar = false;
                    this.uploadPercentage_ = 0;
                    this.listEvent();
                    $('#upload-img').modal('hide');
                }).catch(err=>{
                    this.uploadPercentage_ = 0;
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
    //    
    },
    mounted() {
        this.listEvent();
        this.listComment();
    },
}
</script>

<style>

</style>
