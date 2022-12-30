<template>
    <main class="main">
        <section class="section-agents section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap pb-2">
                        <div class="title-box">
                        <h2 class="title-a ">Academics</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </section> 

      <section class="pt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <input type="text" class="form-control mb-4" v-model="tableData.search"  @input="listAcademic()" placeholder="Search....">
                    <h5>Subjects:</h5>
                    <ul class="list-group list-group-sm">                                 
                        <li class="list-group-item d-flex justify-content-between shadow-sm" v-for="(list, index) in academics" :key="index">
                           <strong class="text-secondary"> {{ list.subject}}</strong>

                            <div class="row ml-2">
                                <div class="col-md-12">
                                    <small>&nbsp; Books:</small>
                                    <div class="table-responsive mb-1">     
                                        <table  class="table p-1">
                                            <tbody>
                                                <tr v-for="(lis, dex) in list.academic_book" :key="dex">
                                                    <td> {{ lis.book.title}} - ({{ lis.book.author }}) </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <div v-show="!noData(academics)">
                            No Result Found!
                        </div>
                        <div class="col-md-12 mt-2">
                            <pagination :pagination="pagination"
                                @prev="listAcademic(pagination.prevPageUrl)"
                                @next="listAcademic(pagination.nextPageUrl)"
                                v-show="noData(academics)">
                            </pagination>
                        </div>
                        
                    </ul>
                    
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
        return{
            academics:[],
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
    },
    mounted() {
        this.listAcademic();
    },
}
</script>

<style>

</style>
