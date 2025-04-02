@extends("manager.app")
@section("content")
<script src="\js\view-source_https___unpkg.com_vue@3.5.13_dist_vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>

<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>
<div id="app">
    <div class="row ">
        <div class=" col-8 ">
            <!-- 分頁選單 -->
            <div class="row justify-content-center">
                <div class="col-8">
                    <select class="form-select form-select-lg mt-3 " v-model="selectedPage">
                        <!-- 動態生成的分頁選項 -->
                        <option :value="item-1" v-for="item in bookDataforPage.length">
                            第@{{ item }}頁
                        </option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <table class="table table-bordered text-center mt-3" style="width: 97%;">
                    <thead class="table-dark">
                        <tr>
                            <th width="10%">訂單編號</th>
                            <th width="17%">email</th>
                            <th width="20%">訂單日期</th>
                            <th width="13%">優惠</th>
                            <th width="25%">宅配地址</th>
                            <th width="15%">操作</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">
                        <!-- Vue.js 動態數據渲染 -->
                        <tr v-for="(item, index) in bookDataforPage[selectedPage]" :key="item.id">
                            <td>@{{ item.id }}</td>
                            <td>@{{ item.email }}</td>
                            <td>@{{ new Date(item.createTime).toLocaleDateString() }}</td>
                            <td>
                                等級優惠: @{{ item.lDiscount === 1 ? "有" : "無" }}<br>
                                生日優惠: @{{ item.bDiscount === 1 ? "有" : "無" }}
                            </td>
                            <td>@{{ item.address }}</td>
                            <td>
                                <button class="btn btn-info" @click="getList(item)">明細</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
        <div class=" col-4" style="background-color:rgb(240, 238, 235); height:95vh; position: relative;">
            <h1 class="my-3 text-center">購物清單</h1>
            <h3 class="text-center mt-2">訂單編號: @{{ orderNumber }}</h3>
            <table id="cartTable" class="text-center w-100">
                <thead>
                    <tr>
                        <th width="30%">品名</th>
                        <th width="30%">價格</th>
                        <th width="30%">數量</th>
                    </tr>
                </thead>
                <tbody class="mt-3">
                    <tr v-for="(item, index) in buyData" :key="item.id">
                        <td style="color:rgb(9, 65, 102);">@{{ item.itemName }}</td>
                        <td>@{{ item.pPrice }}</td>
                        <td>@{{ item.amount }}</td>

                    </tr>
                </tbody>
            </table>
            <div class="mt-5 row">
                <div class="col text-center">原價: @{{ totalPrice }}</div>
                <div class="col text-center">折扣價: @{{ discPrice }}</div>
            </div>

        </div>
    </div>


</div>

<script>
    const App = {
        data() {
            return {
                bookData: [],
                bookDataforPage: [],
                selectedPage: 0,
                buyData: [],
                orderNumber: "",
                totalPrice: "",
                discPrice: ""

            }
        },
        created() {
            const vm = this;
            axios.get('clientBook')
                .then(function(response) {
                    console.log(response);
                    if (response.data.state) {
                        vm.bookData = response.data.data; // 設置用戶數據
                        vm.dataReset(); // 初始化分頁
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
        methods: {
            dataReset() {
                const vm = this;
                vm.bookData.forEach((item, key) => {
                    if (key % 10 == 0) {
                        vm.bookDataforPage.push([]);
                    }
                    const page = parseInt(key / 10);
                    vm.bookDataforPage[page].push(item);
                });
                vm.selectedPage = 0; // 重置為第一頁
            },
            getList(item) {
                const vm = this;
                axios.get(`/api/getSale/${item.id}`)
                    .then(function(response) {
                        console.log(response);
                        if (response.data.state) {
                            vm.buyData = response.data.data; // 設置用戶數據
                            vm.orderNumber = item.id;
                            vm.totalPrice = item.totalPrice;
                            vm.discPrice = item.discPrice;
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
            }
        },

    };
    Vue.createApp(App).mount('#app');
</script>
@endsection