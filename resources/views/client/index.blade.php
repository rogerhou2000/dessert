@extends("client.app")
@section("content")
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script src="/js/leaflet.markercluster.js"></script>
<script src="/js/leaflet-color-markers.js"></script>
<script src="\js\view-source_https___unpkg.com_vue@3.5.13_dist_vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
<style>
    .product-img {
        object-fit: cover;
        width: 90%;
        aspect-ratio: 0.85;
    }
</style>
<style>
    .marker-cluster-medium {
        background-color: rgba(238, 13, 182, 0.2);
    }

    .marker-cluster-medium div {
        background-color: rgba(212, 78, 100, 0.8);
    }

    .marker-cluster-small {
        background-color: rgba(28, 13, 238, 0.2);
    }

    .marker-cluster-small div {
        background-color: rgba(189, 238, 12, 0.8);
    }

    .marker-cluster div {
        width: 30px;
        height: 30px;
        margin-left: 5px;
        margin-top: 5px;
        font-size: 16px;
        font-weight: 900;
        text-align: center;
        border-radius: 50%;
    }

    .marker-cluster span {
        line-height: 30px;
    }
</style>
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>
<div id="app">
    <div class="row ">
        <div class="col-md-9 col-7 " style="overflow-y: auto; height:95vh">
            <div class="mx-md-5 mx-2">

                <div class="row justify-content-center">
                    <div class="col-md-3 mt-3 col-6">
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
                                            <div class="mb-3" style="height: 16px;">

                                                <i class="fa-solid fa-cart-shopping fa-2x  " style="cursor: pointer; color:rgb(109, 89, 145);" @click="handleClick(item)" v-if="!buyData.find(t=>t.id===item.id)"></i>
                                            </div>
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

    </div>
    <div class="col-md-3 col-5" style="background-color:rgb(240, 238, 235); height:95vh; position: relative;">
        <h1 class="my-3 text-center">購物清單</h1>
        <table id="cartTable" class="text-center w-100">
            <thead>
                <tr>
                    <th width="30%">品名</th>
                    <th width="18%">價格</th>
                    <th width="15%">數量</th>
                    <th width="37%">操作</th>
                </tr>
            </thead>
            <tbody class="mt-3">
                <tr v-for="(item, index) in buyData" :key="item.id">
                    <td style="color:rgb(9, 65, 102);">@{{ item.itemName }}</td>
                    <td>@{{ item.price }}</td>
                    <td>@{{ item.amount }}</td>
                    <td>
                        <button class="quantity-btn" @click="changeQuantity(item, 1)">+</button>
                        <button class="quantity-btn" @click="changeQuantity(item, -1)">-</button>
                        <button class="remove-btn" @click="removeItem(index)">移除</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="mt-3 justify-content-end px-3 text-end ">總價:@{{totalPrice}}元</p>
        <!-- 提交按鈕 -->
        <button type="button" class="btn  w-20" v-if="buyData.length>0"
            style="position: absolute; bottom: 35px; right: 20px; background-color:rgb(192, 194, 105)
            ;"
            data-bs-toggle="modal" data-bs-target="#submitCartModal">
            提交購物車
        </button>
    </div>
    <div class="modal fade" id="submitCartModal" tabindex="-1" aria-labelledby="submitCartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 600px;;">
                <!-- 標題 -->
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="submitCartModalLabel">確認提交購物車</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="關閉"></button>
                </div>
                <!-- 模態框內容 -->
                <div class="modal-body">
                    <table id="cartTable" class=" w-100">
                        <thead>
                            <tr>
                                <th width="33%">品名</th>
                                <th width="33%">價格</th>
                                <th width="33%">數量</th>
                            </tr>
                        </thead>
                        <tbody class="mt-3">
                            <tr v-for="(item, index) in buyData" :key="item.id">
                                <td style="color:rgb(9, 65, 102);">@{{ item.itemName }}</td>
                                <td>@{{ item.price }}</td>
                                <td>@{{ item.amount }}</td>

                            </tr>
                        </tbody>
                    </table>
                    <p class="mt-4">總價:@{{totalPrice}}元&nbsp;&nbsp;優惠價:@{{discount}}</p>
                    @php $birthday= date('m', strtotime(session()->get("member")->birthday));@endphp
                    <p>生日優惠:{{date('m')==$birthday?"有，享受專屬折扣！":"無"}}
                    <p>等級優惠:{{session()->get("member")->level>=20?"有":"無"}}</p>
                    <div class="mt-3">送貨地址:
                        <label>
                            <input type="radio" name="deliveryOption" value="home" v-model="deliveryOption">
                            到府
                        </label>
                        <label>
                            <input type="radio" name="deliveryOption" value="postOffice" v-model="deliveryOption">
                            郵局<template v-if="office"> :@{{office}}</template>
                        </label>
                    </div>
                    <div v-if="deliveryOption === 'postOffice'" class="mt-3">
                        <label for="city">選擇縣市:</label>
                        <div v-if="city.length > 0">
                            <select v-model="selectedCity" id="city" style="max-height: 150px; overflow-y: auto;">
                                <option v-for="(item, index) in city" :key="index" :value="item.CityName">@{{ item.CityName }}</option>
                            </select>
                        </div>

                    </div>
                    <div class="mt-1 " :class="{'d-none':deliveryOption !== 'postOffice'}">
                        <div id="map" style="height: 500px; width: 100%;"></div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-success" @click="confirmSubmit">確認提交</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>

<script>
    const App = {
        data() {
            return {
                type: [],
                selectedType: '',
                listData: [],
                buyData: [],
                birthdayOff: "{{date('m')==$birthday}}",
                levelOff: "{{session()->get('member')->level>=20}}",
                city: "",
                selectedCity: "",
                postoffice: "",
                office: "",
                filterPost: "",
                deliveryOption: "home",
                map: null
            }
        },
        created() {
            const vm = this;
            axios.get('/api/getType')
                .then(function(response) {
                    console.log(response);
                    if (response.data.state) {
                        vm.type = response.data.data;
                        vm.selectedType = vm.type[0].id

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
            if (sessionStorage.getItem('buyData')) {
                try {
                    vm.buyData = JSON.parse(sessionStorage.getItem('buyData'));
                } catch (e) {
                    sessionStorage.removeItem('buyData');
                }
            }
            $.ajax({
                type: "GET",
                url: "/js/CityCountyData.json",
                dataType: "json",
                async: false,
                success: function(data) {
                    console.log(data);
                    for (let i = data.length - 1; i >= 0; i--) {
                        if (data[i].CityName === "釣魚臺" || data[i].CityName === "南海島") {
                            data.splice(i, 1); // 從陣列中移除符合條件的城市
                        }
                    }
                    vm.city = data;



                    vm.selectedCity = vm.city[0].CityName;
                },
                error: function() {
                    console.log("error-js/CityCountyData.json");
                },
            });
            $.ajax({
                type: "GET",
                url: "/js/postoffice.json",
                dataType: "json",
                async: false,
                success: function(data) {
                    console.log(data);
                    vm.postoffice = data;
                    vm.filterPost = vm.postoffice.filter(item => item.縣市 === vm.selectedCity);
                },
                error: function() {
                    console.log("error-js/postoffice.json");
                },
            });
        },
        computed: {
            filteredItems() {
                return this.listData.filter(item => item.typeId === this.selectedType);
            },
            totalPrice() {
                var sum = 0;
                this.buyData.forEach(element => {

                    sum += element.price * element.amount;

                });
                return sum;

            },
            discount() {
                let price = this.totalPrice; // 使用 this 引用 totalPrice 計算屬性

                if (this.levelOff) {
                    price *= 0.9;
                    // 等級折扣 10%
                }
                if (this.birthdayOff) {
                    price *= 0.9;
                    // 生日折扣 10%
                }

                return Math.floor(price); // 返回折扣後的整數價格
            }


        },
        watch: {
            buyData: {
                handler(buyData) {
                    sessionStorage.setItem('buyData', JSON.stringify(buyData));
                },
                deep: true
            },
            deliveryOption: function(newValue) {
                const vm = this;
                if (newValue === "postOffice") {
                    vm.initMap(vm.filterPost);
                }
            },
            selectedCity: function(newValue) {
                const vm = this;
                vm.filterPost = vm.postoffice.filter(item => item.縣市 === vm.selectedCity);
                vm.initMap(vm.filterPost);
            }


        },
        methods: {
            handleClick(item) {
                var common = {
                    id: item.id,
                    itemName: item.itemName,
                    price: item.price,
                    amount: 1
                };

                this.buyData.push(common)

            },
            changeQuantity(item, amount) {
                // 更新數量
                item.amount += amount;
                // 防止數量變成負數或零
                if (item.amount < 1) item.amount = 1;
                if (item.amount > 10) item.amount = 10;
            },
            removeItem(index) {
                // 移除購物車中的商品
                Swal.fire({
                    title: "確定要移除購物車嗎？",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "是的",
                    cancelButtonText: "取消"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.buyData.splice(index, 1);
                        Swal.fire("已移除", "商品已從購物車移除", "success");
                    }
                });
            },
            initMap(postOfficeData) {
                vm = this;
                if (this.map) {
                    this.map.remove(); // 移除舊地圖
                }

                // 創建新的地圖
                this.map = L.map("map").setView([25.0330, 121.5654], 13);
                L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 15,
                    minZoom: 10,
                }).addTo(this.map);

                // 初始化標記群組
                const markers = L.markerClusterGroup({
                    disableClusteringAtZoom: 14
                });


                let cnt = 0; // 用於設定第一個郵局的位置
                postOfficeData.forEach((item) => {
                    if (item.緯度 && item.經度) {
                        const lat = parseFloat(item.緯度);
                        const lng = parseFloat(item.經度);

                        const popHTML = `
                <div class="card img-fluid" ">
                    <div class="card-header h2 fw-900 text-bg-success">${item.局名}</div>
                    <div class="card-body">
                        <p class="h5 fw-900">地址: ${item.位置}</p>
                        <button id="checkPost" class="btn btn-primary mt-2" data-name="${item.局名}">確認郵局</button>
                    </div>
                </div>`;

                        if (cnt === 0) {
                            this.map.panTo([lat, lng]); // 設定地圖中心
                        }

                        markers.addLayer(L.marker([lat, lng]).bindPopup(popHTML))
                        cnt++;
                    }
                });
                $("#map").on("click", "#checkPost", function(event) {
                    const postOfficeName = $(this).data("name");
                    vm.office = postOfficeName;
                });


                // 添加標記群組到地圖
                this.map.addLayer(markers);


                // 確保地圖正確渲染
                setTimeout(() => {
                    this.map.invalidateSize();
                }, 1000);
            },
            confirmSubmit() {
                const vm = this;
                // 檢查送貨地址是否填寫
                if (this.deliveryOption === "postOffice" && !this.office) {
                    Swal.fire({
                        title: "未填郵局地址！",
                        icon: "warning",
                        confirmButtonText: "好的"
                    });
                    return; // 停止提交
                }

                // 確定送貨地點
                const deliver = this.deliveryOption === "home" ? "自宅" : this.office;
              

                // 發送 POST 請求
                axios.post('submit', {
                        buyData: vm.buyData,
                        birthdayOff: vm.birthdayOff,
                        levelOff: vm.levelOff,
                        totalPrice: vm.totalPrice,
                        discountPrice: vm.discount,
                        deliver: deliver
                    })
                    .then(response => {
                        if (response.data.state) {
                            Swal.fire({
                                title: '操作成功',
                                text: response.data.message,
                                icon: 'success'
                            }).then(() => {
                                console.log(response.data.data);
                                sessionStorage.clear();
                                location.href = "/client/index"; // 跳轉至首頁
                            });
                        } else {
                            Swal.fire({
                                title: '操作失敗',
                                text: response.data.message,
                                icon: 'error'
                            });
                            console.log(response.data.data);
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: '伺服器錯誤',
                            text: error.response?.data?.message || error.message,
                            icon: 'error'
                        });
                    });
            }

        },





    };
    Vue.createApp(App).mount('#app');
</script>
@endsection