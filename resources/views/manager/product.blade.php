@extends("manager.app")
@section("content")
<script src="\js\view-source_https___unpkg.com_vue@3.5.13_dist_vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>
<div id="app" class="container mt-3 ">
    <div class="row">
        <div class="col-12 p-3 mt-3">
            <!-- 新增品項按鈕 -->
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addItemModal">
                新增品項
            </button>

            <!-- 新增品項 Modal -->
            <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title fw-900" id="addItemModalLabel">新增產品</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="productName" class="form-label">品名</label>
                                    <input type="text" class="form-control " id="productName" :class="{ 'is-invalid': !newItem.flag_name, 'is-valid': newItem.flag_name }" v-model="newItem.itemName" placeholder="2~10個字">
                                    <div class="valid-feedback">符合規則</div>
                                    <div id="nProduct" class="invalid-feedback">
                                        不符合規則
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="productCategory" class="form-label">類別</label>
                                    <select class="form-select" v-model="newItem.typeId">
                                        <option v-for="category in type" :value="category.id" :key="category.id">
                                            @{{ category.typeName }}
                                        </option>
                                    </select>

                                </div>
                                <div class=" mb-3">
                                    <label for="productPrice" class="form-label">價格</label>
                                    <input type="number" class="form-control" id="productPrice" v-model="newItem.price" min=15 max=200 step="5">
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="productStatus" v-model="newItem.status">
                                        <label class="form-check-label" for="productStatus">
                                            上架
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="productIngredients" class="form-label">材料</label>
                                    <input type="text" class="form-control" id="productIngredients" v-model="newItem.ingredients" :class="{ 'is-invalid': !newItem.flag_ingr, 'is-valid': newItem.flag_ingr }" placeholder="20個字以下">
                                    <div class="valid-feedback">符合規則</div>
                                    <div class="invalid-feedback">不符合規則</div>
                                </div>
                                <div class="mb-3">
                                    <label for="productDescription" class="form-label">介紹</label>
                                    <textarea class="form-control" id="productDescription" v-model="newItem.description" :class="{ 'is-invalid': !newItem.flag_des, 'is-valid': newItem.flag_des }" placeholder="30個字以下"></textarea>
                                    <div class="valid-feedback">符合規則</div>
                                    <div class="invalid-feedback">不符合規則</div>
                                </div>
                                <div class="mb-3">
                                    <label for="productImage" class="form-label">圖片</label>
                                    <input type="file" class="form-control" id="productImage" @change="onImageSelected">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary" @click="addItem" data-bs-dismiss="modal">儲存</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- 分類頁籤 -->
            <ul class="nav nav-tabs">
                <template v-for=" category in type" :key="category.id">
                    <li class="nav-item">
                        <a class="nav-link" href="#"
                            @click="activeCategory = category.id"
                            :class="{ 'active': activeCategory === category.id }">
                            @{{ category.typeName }}
                        </a>
                    </li>
                </template>
            </ul>


            <!-- 商品卡片顯示 -->
            <div class="row mt-3 justify-content-center ">
                <template v-for="(item, index) in filteredItems" :key="index">
                    <div class="col-md-6 mt-3 p-lg-2">
                        <div class="card shadow rounded-4 h-100 " style="max-width: 100%;  color:#221515; background-color: #FCC6B0; border-top: outset  rgb(250, 73, 3); border-bottom: 2.5px inset rgba(250, 73, 3, 0.77);">
                            <div class="row g-0 h-100">
                                <!-- 左側敘述 -->
                                <div class="col-7 d-flex flex-column  justify-content-center ">
                                    <div class=m-3>
                                        <h5 class="card-title fw-800 fs-4" style="color:rgb(66, 85, 60);">@{{ item.itemName }}</h5>
                                        <p class="card-text"><strong>類別：</strong>@{{ type.find(t => t.id === item.typeId)?.typeName || '未知' }}</p>
                                        <p class="card-text"><strong>價格：</strong>@{{ item.price }} 元</p>
                                        <p class="card-text"><strong>材料：</strong>@{{ item.ingredient || '無' }}</p>
                                        <p class="card-text"><strong>介紹：</strong>@{{ item.description || '無' }}</p>
                                        <p class="card-text">
                                            <strong>狀態：</strong>
                                            <span class="fw-700" :class="item.status == '1' ? 'text-success' : 'text-danger'">
                                                @{{ item.status == '1'? '上架' : '下架' }}
                                            </span>
                                        </p>
                                        <button class="btn  mt-3 me-1" @click="prepareUpdate(item)" data-bs-toggle="modal" data-bs-target="#updateItemModal" style=" background-color:rgba(233, 136, 25, 0.79); color:rgb(1, 38, 117) ">更新</button>
                                        <button class="btn mt-3 ms-1" @click="deleteItem(item.id)" style="background-color:rgba(220, 53, 69, 0.9); color:white;">刪除</button>
                                    </div>
                                </div>
                                <!-- 右側圖片 -->
                                <div class="col-5 d-flex align-items-center justify-content-center">
                                    <div class="img-fluid rounded"
                                        :style="{ 
                            backgroundImage: `url(${item.img ? '/images/product/' + item.img : '/images/nopicture.png'})`,
                            backgroundSize: 'cover',
                            backgroundPosition: 'center',
                            backgroundRepeat: 'no-repeat',
                            width: '90%',
                           aspectRatio: '0.85'
                        }">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </div>
    <!-- 更新品項 Modal -->
    <div class="modal fade" id="updateItemModal" tabindex="-1" aria-labelledby="updateItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title fw-900" id="updateItemModalLabel">更新品項</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="updateProductName" class="form-label">品名</label>
                            <input type="text" class="form-control" id="updateProductPrice" v-model="updateItem.itemName" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">類別</label>
                            <select class="form-select" v-model="updateItem.type">
                                <option v-for="category in type" :value="category.id" :key="category.id">
                                    @{{ category.typeName }}
                                </option>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="updateProductPrice" class="form-label">價格</label>
                            <input type="number" class="form-control" id="updateProductPrice" v-model="updateItem.price" step="5">
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="productStatus" v-model="updateItem.status">
                                <label class="form-check-label" for="productStatus">
                                    上架
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="updateProductIngredients" class="form-label">材料</label>
                            <input type="text" class="form-control" id="updateProductIngredients" v-model="updateItem.ingredients" :class="{ 'is-invalid': !updateItem.flag_ingr, 'is-valid': updateItem.flag_ingr }">
                            <div class="valid-feedback">符合規則</div>
                            <div class="invalid-feedback">不符合規則</div>
                        </div>
                        <div class="mb-3">
                            <label for="updateProductDescription" class="form-label">介紹</label>
                            <textarea class="form-control" id="updateProductDescription" v-model="updateItem.description" :class="{ 'is-invalid': !updateItem.flag_des, 'is-valid': updateItem.flag_des }"></textarea>
                            <div class="valid-feedback">符合規則</div>
                            <div class="invalid-feedback">不符合規則</div>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">圖片</label>
                            <input type="file" class="form-control" id="productImage" @change="onImageSelectedU">
                            <div v-if="updateItem.image" class="img-fluid rounded"
                                :style="{ 
                            backgroundImage: `url(${updateItem.image})`,
                            backgroundSize: 'cover',
                            backgroundPosition: 'center',
                            backgroundRepeat: 'no-repeat',
                            width: '90%',
                           aspectRatio: '0.85'
                        }">

                            </div>
                            <div v-else-if="updateItem.oldImage">
                                <img :src="'/images/product/'+updateItem.oldImage" alt="商品圖片" class="img-thumbnail">
                            </div>
                            <div v-else>
                                <p>尚未上傳圖片</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" @click="itemUpdate" data-bs-dismiss="modal">保存更新</button>
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
                activeCategory: '', // 預設分類
                newItem: {
                    itemName: '',
                    typeId: 1, // 傳遞為 typeId
                    price: 15,
                    status: true, // 預設為上架
                    ingredients: "",
                    description: "",
                    image: "",
                    flag_name: "",
                    flag_ingr: true,
                    flag_des: true,
                },
                updateItem: {
                    id: '',
                    itemName: '',
                    type: '',
                    oldType: '',
                    price: '',
                    state: true,
                    ingredients: '',
                    description: '',
                    image: '',
                    imgFile: '',
                    oldImage: '',
                    flag_ingr: true,
                    flag_des: true
                },
                listData: []
            };
        },
        created() {
            // 初始化時獲取用戶數據
            const vm = this;
            axios.get('/api/getType')
                .then(function(response) {
                    console.log(response);
                    if (response.data.state) {
                        vm.type = response.data.data;
                        vm.activeCategory = vm.type[0].id

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
                return this.listData.filter(item => item.typeId === this.activeCategory);
            }
        },
        methods: {
            onImageSelected(event) {
                this.newItem.image = event.target.files[0]; // 獲取圖片文件
                console.log(event.target.files[0]);
            },
            onImageSelectedU(event) {
                const files = event.target.files; // 獲取圖片文件

                if (files && files[0]) { // 確保文件存在
                    // 創建臨時 URL 以預覽圖片
                    this.updateItem.imgFile = files[0];
                    this.updateItem.image = URL.createObjectURL(files[0]);



                } else {
                    this.updateItem.image = ''; // 如果沒有文件，設為空
                }
            },
            addItem() {
                const vm = this;

                if (vm.newItem.flag_name &&
                    vm.newItem.flag_ingr &&
                    vm.newItem.flag_des) {
                    const formData = new FormData();
                    formData.append('itemName', vm.newItem.itemName);
                    formData.append('typeId', vm.newItem.typeId);
                    formData.append('price', vm.newItem.price);
                    formData.append('ingredients', vm.newItem.ingredients);
                    formData.append('state', vm.newItem.status);
                    formData.append('description', vm.newItem.description);
                    formData.append('image', vm.newItem.image);

                    for (const value of formData.values()) {
                        console.log(value);
                    }
                    axios.post('add', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            },
                        })
                        .then(function(response) {

                            if (response.data.state) {
                                Swal.fire({
                                    icon: "success",
                                    title: response.data.message,
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: "確認",
                                    denyButtonText: `Don't save`,
                                    allowOutsideClick: false,
                                }).then((result) => {

                                    location.href = "/manager/product/index"
                                });

                            } else {
                                console.log(response.data.message);
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

                } else {
                    Swal.fire({
                        title: "欄位錯誤", // 顯示請求錯誤
                        icon: 'error'
                    });
                }

            },
            async itemUpdate() {
                const vm = this;

                // 確認欄位是否填寫正確
                if (vm.updateItem.flag_ingr && vm.updateItem.flag_des) {

                    if (vm.updateItem.oldType !== vm.updateItem.type) {
                        console.log("檢測到類別更改");

                        const result = await Swal.fire({
                            title: "確定更改類別?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "確認更改",
                            cancelButtonText: "取消更改",
                        });

                        if (!result.isConfirmed) {
                            // 用戶取消，恢復舊類別
                            vm.updateItem.type = vm.updateItem.oldType;

                        }
                    }
                    // 構建表單數據
                    const formData = new FormData();
                    formData.append('id', vm.updateItem.id);
                    formData.append('typeId', vm.updateItem.type);
                    formData.append('price', vm.updateItem.price);
                    formData.append('ingredients', vm.updateItem.ingredients);
                    formData.append('state', vm.updateItem.status);
                    formData.append('description', vm.updateItem.description);
                    formData.append('img', vm.updateItem.imgFile);

                    for (const value of formData.values()) {
                        console.log(value);
                    }
                    axios.post('update', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            },
                        })
                        .then(function(response) {

                            if (response.data.state) {
                                Swal.fire({
                                    icon: "success",
                                    title: response.data.message,
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: "確認",
                                    denyButtonText: `Don't save`,
                                    allowOutsideClick: false,
                                }).then((result) => {

                                    location.href = "/manager/product/index"
                                });

                            } else {
                                console.log(response.data.message);
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

                } else {
                    // 顯示欄位驗證失敗的錯誤提示
                    await Swal.fire({
                        title: "欄位錯誤，請檢查輸入的資料",
                        icon: "error",
                    });
                }
            },
            submitUpdate() {
                const vm = this;
                const formData = new FormData();
                formData.append('id', vm.updateItem.id);
                formData.append('typeId', vm.updateItem.type);
                formData.append('price', vm.updateItem.price);
                formData.append('ingredients', vm.updateItem.ingredients);
                formData.append('status', vm.updateItem.status);
                formData.append('description', vm.updateItem.description);
                formData.append('img', vm.updateItem.imgFile);

                for (const value of formData.values()) {
                    console.log(value);
                }
                axios.post('update', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    })
                    .then(function(response) {

                        if (response.data.state) {
                            Swal.fire({
                                icon: "success",
                                title: response.data.message,
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: "確認",
                                denyButtonText: `Don't save`,
                                allowOutsideClick: false,
                            }).then((result) => {

                                location.href = "/manager/product/index"
                            });

                        } else {
                            console.log(response.data.message);
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
            prepareUpdate(item) {
                let vm = this; // Reference the Vue instance
                vm.updateItem.id = item.id;
                vm.updateItem.itemName = item.itemName;
                vm.updateItem.type = item.typeId;
                vm.updateItem.oldType = item.typeId;
                vm.updateItem.price = item.price;
                vm.updateItem.status = item.status == 1 ? true : '';
                vm.updateItem.ingredients = item.ingredient || '';
                vm.updateItem.description = item.description || '';
                vm.updateItem.oldImage = item.img || '';
                vm.updateItem.flag_ingr = true;
                vm.updateItem.flag_des = true;

            },
            deleteItem(id) {
                // 第一次 SweetAlert 確認
                Swal.fire({
                    title: "您確定要刪除此項目嗎？",
                    text: "此操作無法撤銷！",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "是的，繼續",
                    cancelButtonText: "取消"
                }).then(firstResult => {
                    if (firstResult.isConfirmed) {
                        // 第二次 SweetAlert 確認
                        Swal.fire({
                            title: "第二次確認！",
                            text: "這將永久刪除此項目，請再次確認。",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "仍然刪除",
                            cancelButtonText: "取消"
                        }).then(secondResult => {
                            if (secondResult.isConfirmed) {
                                // 第三次 SweetAlert 確認
                                Swal.fire({
                                    title: "最後一次確認！",
                                    text: "真的要執行刪除操作嗎？",
                                    icon: "error",
                                    showCancelButton: true,
                                    confirmButtonText: "是的，刪除它",
                                    cancelButtonText: "取消"
                                }).then(thirdResult => {
                                    if (thirdResult.isConfirmed) {
                                        // 確認後呼叫後端 API
                                        this.confirmDelete(id);
                                    } else {
                                        Swal.fire("已取消", "刪除操作已取消", "info");
                                    }
                                });
                            } else {
                                Swal.fire("已取消", "刪除操作已取消", "info");
                            }
                        });
                    } else {
                        Swal.fire("已取消", "刪除操作已取消", "info");
                    }
                });
            },
            confirmDelete(id) {
                // 與後端進行串接，發送刪除請求
                axios.delete(`delete/${id}`)
                    .then(function(response) {

                        if (response.data.state) {
                            Swal.fire({
                                icon: "success",
                                title: response.data.message,
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: "確認",
                                denyButtonText: `Don't save`,
                                allowOutsideClick: false,
                            }).then((result) => {

                                location.href = "/manager/product/index"
                            });

                        } else {
                            console.log(response.data.message);
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
        watch: {

            'newItem.itemName': function(value) {
                const vm = this;
                const inputElement = $("#nProduct"); // 假設這是輸入框的元素

                if (value.length > 1 && value.length < 10) {
                    const matchedItem = vm.listData.find(item => item.itemName === value);
                    console.log(matchedItem);
                    this.newItem.flag_name = matchedItem ? false : true;


                    if (matchedItem) {
                        inputElement.text("重複品項");
                    }
                } else {
                    this.newItem.flag_name = false;

                    // 處理長度不符合規則的情況
                    inputElement.text("不符合規則");
                }
            },
            'newItem.price': function(value) {
                if (value < 15) {
                    this.newItem.price = 15; // 限制最低價格
                } else if (value > 200) {
                    this.newItem.price = 200; // 限制最高價格
                }
            },
            'newItem.ingredients': function(value) {
                this.newItem.flag_ingr = value.length < 20;


            },
            'newItem.description': function(value) {
                this.newItem.flag_des = value.length < 40;
            },

            'updateItem.price': function(value) {
                if (value < 15) {
                    this.updateItem.price = 15; // 限制最低價格
                } else if (value > 200) {
                    this.updateItem.price = 200; // 限制最高價格
                }
            },
            'updateItem.ingredients': function(value) {
                this.updateItem.flag_ingr = value.length < 20;


            },
            'updateItem.description': function(value) {
                this.updateItem.flag_des = value.length < 40;
            },
        }
    };

    Vue.createApp(App).mount('#app');
</script>

@endsection