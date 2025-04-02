@extends("front.app")
@section("title")
    <h1 class="text-white" style="text-decoration: underline;  text-underline-offset: 10px; ">產品介紹</h1>
    
    
    <h1 class="text-white">product</h1>
  
@endsection
@section("content")
<script src="\js\view-source_https___unpkg.com_vue@3.5.13_dist_vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
<style>
    .product-img {
        object-fit: cover;
        width: 90%;
        aspect-ratio: 0.85;
    }
</style>

<div id="app">
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-3 mt-3 col-7">
                <select class="form-select form-select-lg" v-model="selectedType">

                    <option :value="item.id" v-for="item in type">
                        @{{item.typeName}}
                    </option>
                </select>
            </div>
        </div>
        <div class="row mt-3 justify-content-center ">
            <template v-for="(item, index) in filteredItems" :key="index">
                <div class="col-lg-6 mt-3 p-lg-2">
                    <div class="card shadow rounded-4 h-100 " style="max-width: 100%;  color:#221515; background-color: #FCC6B0; border-top: outset  rgb(250, 73, 3); border-bottom: 2.5px inset rgba(250, 73, 3, 0.77);">
                        <div class="row g-0 h-100">
                            <!-- 左側敘述 -->
                            <div class="col-6 d-flex flex-column  justify-content-center ">
                                <div class=m-3>
                                    <h5 class="card-title fw-800 fs-4" style="color:rgb(66, 85, 60);">@{{ item.itemName }}</h5>
                                    <p class="card-text"><strong>類別：</strong>@{{ type.find(t => t.id === item.typeId)?.typeName || '未知' }}</p>
                                    <p class="card-text"><strong>價格：</strong>@{{ item.price }} 元</p>
                                    <p class="card-text"><strong>材料：</strong>@{{ item.ingredient || '無' }}</p>
                                    <p class="card-text"><strong>介紹：</strong>@{{ item.description || '無' }}</p>
                                </div>
                            </div>
                            <!-- 右側圖片 -->
                            <div class="col-6 d-flex align-items-center justify-content-center">
                                <img
                                    :src="item.img ? '/images/product/' + item.img : '/images/nopicture.png'"
                                    class="product-img img-fluid rounded"
                                    :alt="item.img ? '產品圖片' : '無圖片可顯示'" />
                            </div>

                        </div>
                    </div>
                </div>
        </div>
        </template>


    </div>

</div>


<script>
    const App = {
        data() {
            return {
                type: [],
                selectedType: "",
                listData: [],
            }
        },
        created() {
            const vm = this;
            axios.get('/api/getType')
                .then(function(response) {
                    console.log(response);
                    if (response.data.state) {
                        vm.type = response.data.data;


                    } else {
                        Swal.fire({
                            title: response.message, // 顯示錯誤信息
                            icon: 'error'
                        });
                    }
                })
                .catch(function(error) {
                    Swal.fire({
                        title: error, // 顯示請求錯誤
                        icon: 'error'
                    });
                });
            axios.get('/api/getProduct')
                .then(function(response) {
                    console.log(response);
                    if (response.data.state) {
                        vm.listData = response.data.data;
                        vm.listData = vm.listData.filter(item => item.status == 1);
                        vm.selectedType = "{{$type}}";
                    } else {
                        Swal.fire({
                            title: response.message, // 顯示錯誤信息
                            icon: 'error'
                        });
                    }
                })
                .catch(function(error) {
                    Swal.fire({
                        title: error, // 顯示請求錯誤
                        icon: 'error'
                    });
                });



        },
        computed: {
            filteredItems() {
                return this.listData.filter(item => item.typeId == this.selectedType);
            },

        },
        watch: {


        },
        methods: {


        }
    };
    Vue.createApp(App).mount('#app');
</script>
@endsection