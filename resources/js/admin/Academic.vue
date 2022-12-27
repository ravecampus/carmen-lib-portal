<template>
    <main id="main">
        <section class="section-services section-t8">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-center">
                        <div class="title-box">
                        <h2 class="title-a ">Academics</h2>
                        <h6 >Set up academics</h6>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="row card card-body">
                    <div class="col-md-12">
                   
                        <input type="text" class="form-control" v-model="tableData.search"  @input="listAcademic()" placeholder="Search....">
                        <hr>
                        <button type="button" @click="showAddModal()" class="btn btn-b-n btn-sm"><i class="fa fa-plus"></i> ADD</button>
                        <data-table class="mt-5">
                            <tbody v-for="(list, idx) in academics" :key="idx">
                                <tr class="shadow-sm">
                                    <td class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                            <strong>{{ list.subject }}</strong>
                                            </div>
                                            <div class="col-md-6">
                                            <small>Books:</small>
                                            <ul class="list-group list-group-sm">
                                                
                                                <li class="list-group-item d-flex justify-content-between" v-for="(lis, dex) in list.academic_book" :key="dex">
                                                    
                                                    {{ lis.book.title}}

                                                    <button type="button" @click="removeBook(lis)" class="btn btn-sm btn-b-n pull-right">Remove</button>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-md-3">
                                        <div class="btn-group pull-right">
                                            <button class="btn btn-sm btn-b-n"  @click="addBook(list)">
                                                <span class="fa fa-plus"></span>
                                                Add Books
                                            </button>
                                            <button class="btn btn-sm btn-b-n"  @click="editAcademic(list)">
                                                <span class="fa fa-edit"></span>
                                                Edit
                                            </button>
                                        </div>
                                        
                                    </td>
                                </tr>
                                 <!-- <tr>
                                    <td colspan="2" v-show="!noData(books)">
                                        No Result Found!
                                    </td>
                                </tr> -->
                                <tr class="spacer"></tr>
                                
                            </tbody>
                        </data-table>
                        <div class="col-md-12">
                            <div class="pull-right">
                                <pagination :pagination="pagination"
                                    @prev="listAcademic(pagination.prevPageUrl)"
                                    @next="listAcademic(pagination.nextPageUrl)"
                                    v-show="noData(academics)">
                                </pagination>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>

        <div class="modal fade academic" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Academics</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                               
                                <div class="form-group col-md-12">
                                    <label>Subject</label>
                                    <input type="text" v-model="post.subject" class="form-control form-control-user" placeholder="Enter Subject">
                                    <span class="errors-material" v-if="errors.subject">{{errors.subject[0]}}</span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" @click="saveAcademic()" class="btn btn-b-n">{{ btncap }}</button>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal fade books" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Add Books <small class="text-secondary">( {{ this.post.subject }} )</small></h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 ">
                                <label>Book Title</label>
                                <div class="input-group mb-2">
                                    <select class="form-control" v-model="post.book" id="inputGroupSelect04">
                                          <option v-for="(ls, dx) in books" :value="ls.id" :key="dx">{{ls.title}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-b-n" @click="addBookToAcademic()" type="button" >Add</button>
                                    </div>
                                   
                                </div>
                                <span class="errors-material" v-if="errors.book">{{errors.book[0]}}</span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item" v-for="(lis, dex) in post.academic_book" :key="dex">{{ lis.book.title}}</li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <!-- <button type="button" @click="saveMagazine()" class="btn btn-b-n">{{ btncap }}</button> -->
                    </div>
                </div>
            </div>
        </div>

        </section>
    </main>
</template>

<script>
import DataTable from '../table/DataTable';
import PaginationVue from '../table/Pagination';

export default {
    components:{
        dataTable:DataTable,
        pagination:PaginationVue
    },
    data(){
        let sortOrders = {};
        let columns =[
        {label:'Title', name:'title'},
        {label:'Author', name:'author'},
        {label:'Copyright', name:'copyright'},
        {label:'Publisher', name:'publisher'},
        {label:'ISBN', name:'isbn'},
        {label:'Action ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{
            post:{},
            errors:[],
            academics:[],
            books:[],
            btncap:"Save",
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
        }
    },
    methods: {
        addBook(data){
            this.post = data;
            $('.books').modal('show');
        },
        showAddModal(){
            this.post = {};
            $('.academic').modal('show');
        },
        editAcademic(data){
            this.post = data;
            $('.academic').modal('show');
        },
        saveAcademic(){
            if(this.post.id > 0){
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.btncap = "Saving...";
                this.$axios.put("api/academic/"+this.post.id, this.post).then(res=>{
                    this.btncap = "Save";
                    this.$emit('show',{'message':'Academic has been modified!', 'status':4});
                    this.post ={};
                    this.errors = [];
                    $('.academic').modal('hide');
                    this.listAcademic();
                }).catch(err=>{
                    this.btncap = "Save";
                    this.errors = err.response.data.errors
                });
            });
            }else{
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                    this.btncap = "Saving...";
                    this.$axios.post("api/academic", this.post).then(res=>{
                        this.$emit('show',{'message':'Academic has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.post ={};
                        this.errors = [];
                        $('.academic').modal('hide');
                        this.listAcademic();
                    }).catch(err=>{
                        this.btncap = "Save";
                        this.errors = err.response.data.errors
                    });
                });
            }
           
        },
        listAcademic(url='api/academic'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.academics = data.data.data;
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
                this.listAcademic();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        listBook(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/book-list').then(res=>{
                    this.books = res.data;
                });
            });
        },
        addBookToAcademic(){
           this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.post('api/academic-book', this.post).then(res=>{
                    this.$emit('show',{'message':'Book has been saved!', 'status':4});
                    $('.books').modal('hide');
                    this.errors = [];
                    this.post = {};
                    this.listAcademic();
                }).catch(err=>{
                    this.errors = err.response.data.errors
                });
            });
        },
        removeBook(data){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.delete('api/academic-book/'+data.id).then(res=>{
                    this.$emit('show',{'message':'Book has been removed!', 'status':4});
                    this.post = {};
                    this.listAcademic();
                }).catch(err=>{
                    this.errors = err.response.data.errors
                });
            });
        }
    },
    mounted() {
        this.listAcademic();
        this.listBook();
    },
}
</script>

<style>

</style>
