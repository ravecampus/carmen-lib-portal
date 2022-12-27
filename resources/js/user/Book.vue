<template>
    <main class="main">
        <section class="section-agents section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap pb-2">
                        <div class="title-box">
                        <h2 class="title-a ">Books</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <input type="text" class="form-control" v-model="tableData.search"  @input="listBook()" placeholder="Search....">
            <hr>
            <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                <tbody class="">
                    <tr class="shadow-sm p-3 m-2"  v-for="(list, idx) in books" :key="idx">
                        <td><strong>{{ list.title }}</strong>
                        </td>
                        <td><span class="status--process">{{ list.author }}</span></td>
                        <td><span>{{ list.copyright }}</span></td>
                        <td><span>{{ list.publisher }}</span></td>
                        <td><span class="text-muted">{{ list.isbn }}</span></td>
                    </tr>
                    <tr>
                        <td colspan="5" v-show="!noData(books)">
                            No Result Found!
                        </td>
                    </tr>
                    <tr class="spacer"></tr>
                    
                </tbody>
            </data-table>
            <div class="col-md-12 mt-3">
                <div class="pull-right">
                    <pagination :pagination="pagination"
                        @prev="listBook(pagination.prevPageUrl)"
                        @next="listBook(pagination.nextPageUrl)"
                        v-show="noData(books)">
                    </pagination>
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
        {label:'Title', name:null},
        {label:'Author', name:null},
        {label:'Copyright', name:null},
        {label:'Publisher', name:null},
        {label:'ISBN', name:null},
        // {label:'Action ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            books:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
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
        listBook(url='api/book'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.books = data.data.data;
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
                this.listBook();
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
        this.listBook()
    },
}
</script>

<style>
</style>