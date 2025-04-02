@extends("manager.app")
@section("content")
<script src="\js\view-source_https___unpkg.com_vue@3.5.13_dist_vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
<script>axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
;</script>
<div id="app">
    <!-- 主容器 -->
    <div class="container mt-3">
        <div class="row justify-content-center">
            <!-- 城市篩選下拉選單 -->
            <div class="col-10">
                
                <select class="form-select form-select-lg" v-model="selectedCity">
                    <!-- 全部選項 -->
                    <option value="all">
                        全部
                    </option>
                    <!-- 動態生成的城市選項 -->
                    <option :value="key" v-for="(item, key) in regionTitle">
                        @{{item}}
                    </option>
                </select>
                <!-- 分頁選單 -->
                <select class="form-select form-select-lg mt-3" v-model="selectedPage">
                    <!-- 動態生成的分頁選項 -->
                    <option :value="item-1" v-for="item in userDataforPage.length">
                        第@{{ item }}頁
                    </option>
                </select>
                
            </div>
        </div>

        <!-- 用戶資料表格 -->
        <div class="mt-3 col-12">
            <table class="table table-bordered table-rwd text-center">
                <thead class="table-dark rounded-2">
                    <tr>
                        <th width="20%">Email</th>
                        <th width="20%">名字</th>
                        <th width="20%">居住地</th>
                        <th width="20%">身分</th>
                        <th width="20%">功能</th>
                    </tr>
                </thead>
                <tbody style="background-color:rgb(240, 238, 238);">
                    <!-- 動態生成用戶數據 -->
                    <tr v-for="item in userDataforPage[selectedPage]">
                        <td data-th="EMAIL">@{{item.email}}</td>
                        <td data-th="名字">@{{item.name}}</td>
                        <td data-th="居住地">@{{item.city}}</td>
                        <!-- 根據用戶級別顯示身分 -->
                        <td data-th="等級" v-if="item.level===1000">最高權限</td>
                        <td data-th="等級" v-else-if="item.level===20">等級2</td>
                        <td data-th="等級" v-else-if="item.level===10">等級1</td>
                        <td data-th="等級" v-else-if="item.level===0">停權</td>
                        <!-- 更新和刪除按鈕 -->
                        <td data-th="功能">
                            <button v-if="item.level > 0&&item.level<1000" class="btn btn-warning me-2"
                                @click="confirmAction(item.id,-1, '停權')">停權</button>
                            <button v-else-if="item.level === 0" class="btn btn-danger"
                                @click="confirmAction(item.id, 1, '復權')">復權</button>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const App = {
        data() {
            return {
                regionData: [], // 重新組織後的城市數據
                regionTitle: [], // 城市名稱列表
                counter: [], // 用於記錄城市索引的計數器
                userData: [], // 從伺服器獲取的原始用戶數據
                userDataAlign: [], // 根據篩選條件篩選的用戶數據
                userDataforPage: [], // 分頁後的用戶數據
                selectedPage: '0', // 當前選中的頁數
                selectedCity: "all" // 當前選中的城市篩選條件
            }
        },
        created() {
            // 初始化時獲取用戶數據
            const vm = this;
            axios.get('getUser')
                .then(function(response) {
                    console.log(response);
                    if (response.data.state) {
                        vm.userData = response.data.data; // 設置用戶數據
                        vm.dataRegion(); // 構建城市數據
                        vm.userDataAlign = vm.userData; // 預設顯示所有用戶
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
        watch: {
            // 當城市篩選條件改變時觸發
            selectedCity: function(newValue) {
                const vm = this;
                if (newValue == "all") {
                    vm.userDataAlign = vm.userData; // 顯示所有用戶
                } else {
                    vm.userDataAlign = vm.regionData[newValue]; // 顯示對應城市的用戶
                }
                vm.dataReset(); // 重新設置分頁
            }
        },
        methods: {
            
            // 根據城市對數據進行分組
            dataRegion() {
                const vm = this;
                vm.userData.forEach((item) => {
                    const getCity = item.city;
                    if (vm.counter[getCity] == undefined) {
                        vm.counter[getCity] = vm.regionData.length; // 為新城市分配索引
                        vm.regionData.push([]); // 初始化該城市的數據數組
                        vm.regionTitle[vm.counter[getCity]] = getCity; // 設置城市名稱
                    }
                    vm.regionData[vm.counter[getCity]].push(item); // 添加用戶到對應城市
                });
            },
            // 根據用戶數據構建分頁
            dataReset() {
                const vm = this;
                vm.userDataforPage = []; // 清空原有分頁
                vm.userDataAlign.forEach((item, key) => {
                    if (key % 10 == 0) {
                        vm.userDataforPage.push([]); // 每10個用戶新建一頁
                    }
                    const page = parseInt(key / 10); // 計算當前頁數
                    vm.userDataforPage[page].push(item); // 添加用戶到對應頁
                });
                vm.selectedPage = 0; // 重置為第一頁
            },
            confirmAction(userId, newLevel, actionText) {
                Swal.fire({
                    title: `您確定要執行 ${actionText} 嗎？`,
                    text: "此操作將立即生效！",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "確定",
                    cancelButtonText: "取消"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // 如果確認，則執行更新操作
                        this.updateUserLevel(userId, newLevel);
                    }
                });
            },
            updateUserLevel(userId, newLevel) {
                const vm=this;
                console.log(userId);
                console.log(newLevel);
                axios.post('updateUserLevel', {
                        id: userId,
                        level: newLevel
                    })
                    .then(response => {
                        if (response.data.state) {
                            Swal.fire({
                                title: '操作成功',
                                text: response.data.message,
                                icon: 'success'
                            });
                            location.href="/manager/client/index" // 重新獲取用戶數據以更新畫面
                        } else {
                            Swal.fire({
                                title: '操作失敗',
                                text: response.data.message,
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: '伺服器錯誤',
                            text: error.message,
                            icon: 'error'
                        });
                    });
            }

        }
    };
    Vue.createApp(App).mount('#app');
</script>
@endsection