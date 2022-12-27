<template>
    <main id="main">
  
     <!-- ======= Latest News Section ======= -->
    <section class="section-news section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Latest Updates</h2>
              </div>
              <div class="title-link">
                <!-- <a href="blog-grid.html">All News
                  <span class="bi bi-chevron-right"></span>
                </a> -->
              </div>
            </div>
          </div>
        </div>

        <div id="updates" class="swiper">
          <div class="swiper-wrapper">

            <div class="carousel-item-c swiper-slide" v-for="(list, idx) in events" :key="idx">
              <div class="card-box-b card-shadow news-box">
                <div class="img-box-b">
                  <img :src="list.image == null ? '../img/logo.jpg' :'../storage/event/'+list.image" alt="" class="img-b img-fluid">
                </div>
                <div class="card-overlay">
                  <div class="card-header-b">
                    <div class="card-category-b">
                      <!-- <a href="#" class="category-b"></a> -->
                      {{ list.title}}
                    </div>
                    <div class="card-title-b">
                      <h2 class="title-2">
                        <a href="#">{{ list.description }}</a>
                      </h2>
                    </div>
                    <div class="card-date">
                      <!-- <span class="date-b">18 Sep. 2017</span> -->
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End carousel item -->

          </div>
        </div>

        <div class="news-carousel-pagination carousel-pagination"></div>
      </div>
    </section><!-- End Latest News Section -->
    </main>
</template>

<script>
export default {
    data(){
      return{
          events:[],
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
    methods:{
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
    },
    mounted() {
        this.listEvent();

       new Swiper('#updates', {
          speed: 600,
          loop: true,
          autoplay: {
            delay: 5000,
            disableOnInteraction: false
          },
          slidesPerView: 'auto',
          pagination: {
            el: '.news-carousel-pagination',
            type: 'bullets',
            clickable: true
          },
          breakpoints: {
            320: {
              slidesPerView: 1,
              spaceBetween: 20
            },

            1200: {
              slidesPerView: 3,
              spaceBetween: 20
            }
          }
        });
    },
}

  /**
   * News carousel
   */
 

</script>

<style>

</style>
