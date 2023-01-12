<template>
    <main class="main">
     <section class="section-services section-t8 d-print-none">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <div class="title-wrap d-flex justify-content-center">
                    <div class="title-box">
                    <h2 class="title-a ">Report</h2>
                    <h6 >Generate report</h6>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </section>
  
        <div class="d-sm-flex align-items-center justify-content-between d-print-none mb-4">
            
            </div>

            <div class="row card mt-5">
                <div class="col-md-12 card-body">
                    
                    <div class="text-center d-none d-print-block mb-5">
                        <h4>CARMEN ACADEMY</h4>
                        <h6>Asia International College Of Science And Technology</h6>
                        <h6>CARMEN, COTABATO</h6>
                    </div>
                    <div class="text-center">
                       <h4> User logs </h4>
                        <small>{{ tableData.datedata == null ? formatDate(new Date()) : formatDate(tableData.datedata) }}(online)</small>
                        <span> - Total of <strong>{{ users.length }}</strong> user/s</span>
                    </div>
                    <hr>
                    <div class="row d-print-none">
                        <!-- <div class="col-md-3">
                            <button type="button" @click="printData()" class="btn btn-b-n btn-sm "><i class="fa fa-print"></i> Print</button>
                        </div> -->
                        <div class="col-md-3">
                            <Datepicker v-model="tableData.datedata" placeholder="Date" :format="format"/>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" v-model="tableData.filter">
                                <option value="">Filter</option>
                                <option value="0">Student</option>
                                <option value="1">Faculty</option>
                                <option value="2">Visitor</option>
                            </select>
                          
                        </div>
                        <div class="col-md-3">
                            <button typr="button" @click="filterData()" class="btn btn-b-n btn-sm"><span class="fa fa-filter"></span>Filter </button>
                            <button type="button" @click="printData()" class="btn btn-b-n btn-sm "><i class="fa fa-print"></i> Print</button>
                        </div>
                        
                    
                    </div>
                    <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                        <tbody v-for="(list, idx) in users" :key="idx">
                            <tr class="tr-shadow">
                                <td><strong>{{ list.first_name }}</strong>
                                </td>
                                <td><span>{{ list.last_name }}</span></td>
                                <!-- <td><span>{{ list.grade_level }}</span></td> -->
                                <td><span>{{ extractRole(list.role) }}</span></td>
                                <td><span>{{ list.email }}</span></td>
                                <td><span>{{  filterNumberLogs(list.id) }}</span></td>
                                <!-- <td><span>{{ list.contact_number }}</span></td> -->
                                <!-- <td><span class="text-success">{{ list.logs.length }}</span></td> -->
                        
                            </tr>
                            <tr class="spacer"></tr>
                            
                        </tbody>
                    </data-table>
                    <!-- <div class="col-md-12 d-print-none">
                        <div class="pull-right">
                            <pagination :pagination="pagination"
                                @prev="listUser(pagination.prevPageUrl)"
                                @next="listUser(pagination.nextPageUrl)"
                                v-show="noData(users)">
                            </pagination>
                        </div>
                        
                    </div> -->

                </div>

                
            </div>
               
    </main>
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
        {label:'First Name', name:null},
        {label:'Last Name', name:null},
        // {label:'Grade Level', name:null},
        {label:'Role', name:null},
        {label:'Email', name:null},
        {label:'Number of logs', name:null},
        // {label:'Contact Number', name:null},
        // {label:'Online Users', name:null},
        // {label:'Action ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{
            fildate:null,
            upload:{},
            btncap:"Save",
            errors:[],
            post:{},
            users:[],
            numlogs:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            btndis: false,
            tableData:{
                datedata:new Date(),
                draw:0,
                length:1000,
                search:'',
                column:0,
                archive:0,
                dir:'desc',
                filter:"",
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
        listUser(url='api/report'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.users = data.data.data;
                        console.log(this.users)
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
                this.listUser();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        confirmDeleteUser(data){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.delete("api/user/"+data.id).then(res=>{
                    this.$emit('show',{'message':'User has been deleted!', 'status':4});
                   
                    this.post ={};
                    $('.delete-user').modal('hide');
                    this.listUser();
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
        printData(){
            window.print();
        },
        extractRole(num){
            return num== 0 ? "Student" :num == 1 ? "Faculty" :num ==2 ? "Visitor" :"Admin";
        },
        filterData(){
            console.log(this.tableData.datedata)
            this.listUser();
            this.fildate = this.tableData.datedata;
        },
        filterNumberLogs(id){
            
            let num = 0;
            this.numlogs.forEach(val => {
                if(val.user_id == id && new Date(val.date).getDate() ==  this.fildate.getDate()){
                    num += val.log;
                   
                }
            });
            return num;
        },
        listLogs(){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.get("api/num-logs/").then(res=>{
                  this.numlogs = res.data;
                });
            });
        }

    },
    mounted() {
        this.fildate = this.tableData.date;
        this.listUser();
        this.listLogs()
    },
}
</script>

<style>

</style>
