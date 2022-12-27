<template>
    <main class="main">
        <section class="section-agents section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap pb-2">
                        <div class="title-box">
                        <h2 class="title-a ">Magazines</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <input type="text" class="form-control" v-model="tableData.search"  @input="listMagazine()" placeholder="Search....">
            <hr>
            <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                <tbody >
                    <tr class="tr-shadow" v-for="(list, idx) in magazines" :key="idx">
                        <td><strong>{{ list.magazine_title }}</strong>
                        </td>
                        <td><span>{{ formatDate(list.date_issued) }}</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" v-show="!noData(magazines)">
                            No Result Found!
                        </td>
                    </tr>
                    <tr class="spacer"></tr>
                    
                </tbody>
            </data-table>
            <div class="col-md-12 mt-3">
                <div class="pull-right">
                    <pagination :pagination="pagination"
                        @prev="listMagazine(pagination.prevPageUrl)"
                        @next="listMagazine(pagination.nextPageUrl)"
                        v-show="noData(magazines)">
                    </pagination>
                </div>
                
            </div>
        </div>
      </section> 
    </main>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import DataTable from '../table/DataTable';
import PaginationVue from '../table/Pagination';

export default {
    components:{
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
        {label:'Title', name:null},
        {label:'Date issued', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{
            btncap:"Save",
            errors:[],
            post:{},
            magazines:[],
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
        }
    },
    methods: {
        listMagazine(url='api/magazine'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.magazines = data.data.data;
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
                this.listMagazine();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },

    },
    mounted() {
        this.listMagazine()
    },
}
</script>

<style>
</style>