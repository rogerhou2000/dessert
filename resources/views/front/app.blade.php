<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/all.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/my.css">
    <link rel="stylesheet" href="/css/MarkerCluster.css">
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr("content")
            }
        });
    </script>
    <style>
        body {
            background-color: #F0E8D3;
        }

        a.disabled {
            pointer-events: none;
            /* 禁止点击 */
            cursor: not-allowed;
            /* 显示禁用的光标 */
        }


        .dropdown-item:hover,
        .dropdown-item:focus,
        .dropdown-item:active {
            background-color: transparent;
            /* 取消背景色變化 */
            color: inherit;
            /* 保持文字顏色不變 */
        }


        .title,
        .dropdown-item span {
            position: relative;
            /* 為偽元素提供定位基準 */
            text-decoration: none;
            /* 移除預設的下劃線 */
            transition: color 0.3s ease-in-out;
            /* 文字顏色變化 */
        }

        .title::after,
        .dropdown-item:hover span::after {
            content: "";
            /* 偽元素內容 */
            position: absolute;
            bottom: 0;
            /* 放在文字底部 */
            left: 0;
            height: 2px;
            /* 下劃線的高度 */
            width: 0%;
            /* 初始寬度為 0 */
            background-color: rgb(253, 253, 253);
            /* 下劃線的顏色 */
            transition: width 0.3s ease, left 0.3s ease;
            /* 平滑效果 */
        }


        .title:hover::after,
        .dropdown-item:hover span::after {
            width: 100%;
            left: 0;
        }

        .title:not(:hover)::after,
        .dropdown-item:not(:hover) span::after {
            left: auto;
            right: 0;
        }
    </style>

</head>

<body>
    <div class="fix top-0 position-sticky row justify-content-end " style="z-index: 100;">
        <section id="s02" class="col-md-6 menu   ms-0" style="z-index: 101;border-top-left-radius: 10px; border-bottom-left-radius: 10px;">

            <div class="container ">
                <nav class="navbar    ">
                    <div class="container-fluid">
                        <!-- 使用 row-cols-3 分欄 -->
                        <div class="row row-cols-3 w-100 align-items-center">
                            <!-- 第一欄 -->
                            <div class="col text-center">
                                <a class="navbar-brand text-white fw-500 fs-4 title  {{ request()->is('/') ? 'disabled' : '' }}" href="/">首頁</a>
                            </div>
                            <!-- 第二欄 -->
                            <div class="col ">
                                <ul class="navbar-nav justify-content-center">
                                    <li class="nav-item dropdown ">
                                        <a class="nav-link dropdown-toggle text-white  fs-4 fw-500 py-2 text-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">產品介紹</a>
                                        <ul class="dropdown-menu position-absolute menu align-item-center " style="  left: 50%; 
                                            transform: translateX(-50%);top: 100%;z-index: 102; ">
                                            <li><a class="dropdown-item menu fs-5 fw-500  text-center " href="/product/1"><span class="title">蛋糕</span></a></li>
                                            <li><a class="dropdown-item menu fs-5 fw-500 text-center " href="/product/2"><span class="title">麵包</span></a></li>
                                            <li><a class="dropdown-item menu fs-5 fw-500  text-center" href="/product/3"><span class="title">派</span></a></li>
                                            <li><a class="dropdown-item menu fs-5 fw-500  text-center" href="/product/4"><span class="title">餅乾</span></a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <!-- 第三欄 -->
                            <div class="col text-center">
                                <a class="navbar-brand text-white fw-500  fs-4 title" data-bs-toggle="modal" data-bs-target="#loginModal" role="button" style="cursor:pointer" id="login_btn">會員中心</a>
                            </div>
                            <!-- <div class="col text-end">
                            <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#loginModal" id="login_btn">會員中心</button>
                        </div> -->
                        </div>
                    </div>
                </nav>
            </div>
        </section>
    </div>

    <!-- registerModal -->
    <div
        class="modal fade"
        id="registerModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header text-bg-warning">
                    <h1 class="modal-title fs-4 fw-900" id="exampleModalLabel">
                        會員註冊
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex flex-column h-100">
                                <div class="display-6 fw-900 my-3">會員須知</div>
                                <ol>
                                    <li class="mt-2">以郵箱註冊</li>
                                    <li class="mt-2">15歲才始註冊</li>
                                    <li class="mt-2">註冊後有訂購查詢訂單情況之功能</li>
                                    <li class="mt-2"><span style="color:brown">如會員進行不當行動，如:惡意未付款，以不正當方式影響訂單。管理方有停權權限</span></li>
                                    <li class="mt-2">優惠1:<div class="block">當月壽星9折</div>
                                        <BR />優惠2:<div class="block">累積購買達1000元累積購買達1000元下次訂單起打9折</div>
                                    </li>
                                </ol>
                                <div class="form-check form-switch mt-auto">
                                    <input
                                        type="checkbox"
                                        class="form-check-input is-invalid"
                                        role="switch"
                                        id="chk01" />
                                    <label for="" class="form-check-label">不同意</label>
                                    <div class="valid-feedback" style="color: #fff">&nbsp;</div>
                                    <div class="invalid-feedback" id="chk01">
                                        須同意始能註冊!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="email_reg" class="form-label">郵箱帳號</label>
                                <input
                                    type="text"
                                    class="form-control is-invalid"
                                    id="email_reg"
                                    name="email_reg"
                                    placeholder="要求email格式" />
                                <div class="valid-feedback">符合規則</div>
                                <div id="emailiv" class="invalid-feedback">
                                    不符合規則
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password_reg" class="form-label">密碼</label>
                                <input
                                    type="password"
                                    class="form-control is-invalid"
                                    id="password_reg"
                                    name="password_reg"
                                    placeholder="3-20字數" />
                                <div class="valid-feedback">符合規則</div>
                                <div class="invalid-feedback">不符合規則</div>
                            </div>
                            <div class="mb-3">
                                <label for="re_password_reg" class="form-label">確認密碼</label>
                                <input
                                    type="password"
                                    class="form-control is-invalid"
                                    id="re_password_reg"
                                    name="re_password_reg" />
                                <div class="valid-feedback">符合規則</div>
                                <div class="invalid-feedback">不符合規則</div>
                            </div>
                            <div class="mb-3">
                                <label for="username_reg" class="form-label">姓名</label>
                                <input
                                    type="text"
                                    class="form-control is-invalid"
                                    id="username_reg"
                                    name="username_reg"
                                    placeholder="3-10字數" />
                                <div class="valid-feedback">符合規則</div>
                                <div class="invalid-feedback">
                                    不符合規則
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">生日</label>
                                <input
                                    type="date"
                                    class="form-control is-invalid"
                                    id="birthday"
                                    name="birthday" max="{{(new DateTime())->modify('-15 years')->format('Y-m-d')}}"
                                    placeholder="3-6字數" />
                                <div class="valid-feedback">符合規則</div>
                                <div class="invalid-feedback">
                                    不符合規則
                                </div>
                            </div>
                            <div class="mt-3 input-group">
                                <span class="input-group-text">地址</span>
                                <select
                                    name="selectCity"
                                    id="selectCity"
                                    class="form-select form-select-sm">
                                    <option value="" class="text-center" selected disabled>
                                        -縣市-
                                    </option>
                                </select>
                                <select
                                    name="selectArea"
                                    id="selectArea"
                                    class="form-select form-select-sm">
                                    <option value="" class="text-center" selected disabled>
                                        -鄉鎮區-
                                    </option>
                                </select>
                                <textarea
                                    id="address"
                                    name="address"
                                    class="input-group-append form-control is-invalid"
                                    style="width: 40%"
                                    placeholder="6字以上"></textarea>
                                <div class="valid-feedback">符合規定</div>
                                <div class="invalid-feedback">不符合規定</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        取消
                    </button>
                    <button type="button" class="btn btn-primary" id="regi_btn">
                        確認
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- loginModal -->
    <div
        class="modal fade"
        id="loginModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header text-bg-warning">
                    <h1 class="modal-title fs-4 fw-900" id="exampleModalLabel">
                        會員登入
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username_login" class="form-label">郵箱帳號</label>
                        <input
                            type="text"
                            class="form-control is-invalid"
                            id="email_login"
                            name="email_login" />
                        <div id=email_login_iv class="invalid-feedback">帳號密碼格式不符</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_login" class="form-label">密碼</label>
                        <input
                            type="password"
                            class="form-control is-invalid"
                            id="password_login"
                            name="password_login" />
                    </div>
                </div>

                <div class="modal-footer ">
                    <div class=" mx-auto align-item-center">
                        <button type="button" class="btn btn-primary" id="btn_login">
                            確認
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            取消
                        </button>

                    </div>

                </div>
                <hr class="my-0">
                <div class="mx-auto my-3">還沒帳號嗎?<button
                        class="btn btn-warning ms-3"
                        data-bs-toggle="modal"
                        data-bs-target="#registerModal"
                        id="reg_btn">
                        註冊
                    </button></div>

            </div>
        </div>
    </div>

    <div style="margin-top: -65.91pt;">
        <!-- banner -->
        <div id="banner" class="bg-cover vw-100 " style="background-image: url('/images/title.png');height:75vh; ">
            <div class="row  h-100">
                <div class="col-6 position-relative">
                    <div class=" position-absolute top-50 start-50 translate-middle  text-center">
                    @yield("title")</div>
                </div>
            </div>

        </div>

        <script src="/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/counterup2@2.0.2/dist/index.js"></script>
        <script src="/js/wow.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @yield("content")

    </div>
    <div class="footer mt-5 bottom-0" style="background-color: #FFA07A; height: 80px; display: flex; justify-content: center; align-items: center; text-align: center;">
        <div class="row w-100">
            <div class="col d-flex justify-content-center align-items-center">Copyright © 2024abcd</div>
            <div class="col d-flex flex-column justify-content-center align-items-center">
                <p style="margin: 0;">地址: 台中市南區忠明南路78號</p>
                <p style="margin: 0;">連絡電話: (09)-00000000</p>

            </div>
            <div class="col d-flex  justify-content-center align-items-center">
                <div class="row">
                    <div class="row ">
                        <div class="col-8 d-flex justify-content-around align-items-center">
                            <a href="https://line.me" target="_blank">
                                <i class="fab fa-line mx-2" style="font-size: 40px; color: #00c300;"></i>
                            </a>
                            <a href="https://facebook.com" target="_blank">
                                <i class="fab fa-facebook mx-2" style="font-size: 40px; color: #1877f2;"></i>
                            </a>
                            <a href="https://instagram.com" target="_blank">
                                <i class="fab fa-instagram mx-2" style="font-size: 40px; background: linear-gradient(90deg, #6C3BA7, #E33F39); -webkit-background-clip: text; color: transparent;"></i>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            var flag_chk01 = false;
            var flag_email_reg = false;
            var flag_password_reg = false;
            var flag_re_password_reg = false;
            var flag_username_reg = false;
            var flag_area = false;
            var flag_road = false;
            var flag_address = false;
            var dateLimit = new Date("{{(new DateTime())->modify('-15 years')->format('Y-m-d')}}").getTime();
            var flag_date = false;
            var city = [];
            var selectedCity;
            // 同意表單
            $("#chk01").change(function() {
                if ($(this).is(":checked")) {
                    $(this).next().text("同意");
                    $(this).removeClass("is-invalid");
                    $(this).addClass("is-valid");
                    flag_chk01 = true;
                } else {
                    $(this).next().text("不同意");
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                    flag_chk01 = false;
                }
            });
            // 及時監聽email
            function validateEmail(email) {
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(email);
            }
            $("#email_reg").bind("input propertychange", function() {

                if (validateEmail(this.value)) {
                    $.ajax({

                        url: "/checkonly",
                        type: "POST",
                        data: {
                            email: $("#email_reg").val(),
                        },
                        dataType: "json",
                        success: function(msg) {
                            console.log(msg);
                            if (msg.state) {
                                $("#email_reg").removeClass("is-invalid");
                                $("#email_reg").addClass("is-valid");
                                flag_email_reg = true;

                            } else {
                                $("#email_reg").removeClass("is-valid");
                                $("#email_reg").addClass("is-invalid");
                                $("#emailiv").html("重複帳號");
                                flag_email_reg = false;
                            }
                        }
                    });

                } else {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                    $("#emailiv").html("不符合規則");
                    flag_email_reg = false;
                }
            });




            //即時監聽password_reg
            $("#password_reg").bind("input propertychange", function() {
                $("#re_password_reg").removeClass("is-valid");
                $("#re_password_reg").addClass("is-invalid");
                flag_re_password_reg = false;

                if ($(this).val().length > 2 && $(this).val().length < 21) {
                    $(this).removeClass("is-invalid");
                    $(this).addClass("is-valid");
                    flag_password_reg = true;
                } else {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                    flag_password_reg = false;
                }
            });
            $("#re_password_reg").bind("input propertychange", function() {
                if (flag_password_reg) {
                    if ($(this).val() == $("#password_reg").val()) {
                        $(this).removeClass("is-invalid");
                        $(this).addClass("is-valid");
                        flag_re_password_reg = true;
                    } else {
                        $(this).removeClass("is-valid");
                        $(this).addClass("is-invalid");
                        flag_re_password_reg = false;
                    }
                }
            });
            //即時監聽username_reg
            $("#username_reg").bind("input propertychange", function() {
                if ($(this).val().length > 2 && $(this).val().length < 11) {
                    $(this).removeClass("is-invalid");
                    $(this).addClass("is-valid");
                    flag_username_reg = true;
                } else {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                    flag_username_reg = false;
                }
            });
            //即時監聽birthday
            $("#birthday").bind("input propertychange", function() {
                var inputDate = new Date($(this).val()).getTime();
                console.log(inputDate);

                if (inputDate <= dateLimit) {
                    $(this).removeClass("is-invalid");
                    $(this).addClass("is-valid");
                    flag_date = true;
                } else {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                    flag_date = false;
                }
            });


            function isaddress() {
                flag_address = flag_road && flag_area;
                if (flag_address) {
                    $("#address").removeClass("is-invalid");
                    $("#address").addClass("is-valid");
                } else {
                    $("#address").addClass("is-invalid");
                    $("#address").removeClass("is-valid");
                }
                console.log(flag_address);
            }


            //即時監聽address
            $("#address").on("input propertychange", function() {
                if ($(this).val().length > 6) {
                    flag_road = true;
                } else {
                    flag_road = false;
                }
                isaddress();
            });
            $.ajax({
                type: "GET",
                url: "js/CityCountyData.json",
                dataType: "json",
                async: false,
                success: function(data) {
                    console.log(data);
                    city = data;
                },
                error: function() {
                    console.log("error-js/CityCountyData.json");
                },
            });
            console.log(city);
            city.forEach(function(item) {
                console.log(item.CityName);

                var strHTML = `<option value="${item.CityName}">${item.CityName}</option>`;
                $("#selectCity").append(strHTML);
            });
            $("#selectCity").on("input propertychange", function() {
                console.log($(this).val());
                selectedCity = $(this).val();
                flag_area = false;

                console.log(flag_address);

                city.forEach(function(item) {
                    if (item.CityName == selectedCity) {
                        //產生鄉鎮區選單
                        $("#selectArea").empty();
                        $("#selectArea").append(
                            '<option value="" class="text-center" selected disabled>-鄉鎮區-</option>'
                        );
                        item.AreaList.forEach(function(myitem) {
                            console.log(myitem.AreaName);

                            var strHTML = `<option value="${myitem.AreaName}">${myitem.AreaName}</option>`;
                            $("#selectArea").append(strHTML);
                        });
                        isaddress();
                    }
                });
            });
            $("#selectArea").on("input propertychange", function() {
                flag_area = true;

                isaddress();
            });

            // 及時監聽regi_btn
            $("#regi_btn").click(function() {
                var flag = flag_chk01 && flag_email_reg && flag_re_password_reg && flag_username_reg && flag_address && flag_date;
                console.log(flag)
                if (flag) {
                    var JSONdata = {};
                    JSONdata["email"] = $("#email_reg").val();
                    JSONdata["password"] = $("#password_reg").val();
                    JSONdata["username"] = $("#username_reg").val();
                    JSONdata["birthday"] = $("#birthday").val();
                    JSONdata["city"] = selectedCity;
                    JSONdata["address"] = selectedCity + $("#selectArea").val() + $("#address").val();



                    $.ajax({
                        url: "/reg",
                        type: "POST",
                        data: JSON.stringify(JSONdata),
                        contentType: "application/json",
                        dataType: "json",
                        success: register,
                        error: function() {
                            Swal.fire({
                                title: "API介接錯誤?",
                                text: "/reg",
                                icon: "error",
                            });
                        },
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "欄位錯誤",
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: "確認",
                        denyButtonText: `Don't save`,
                        allowOutsideClick: false,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {}
                    });
                }
            });

            function register(data) {
                console.log(data);
                if (data.state) {
                    Swal.fire({
                        icon: "success",
                        title: data.message,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: "確認",
                        denyButtonText: `Don't save`,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var JSONdata = {};
                            JSONdata["email"] = data.data.email;
                            JSONdata["password"] = data.data.password;
                            console.log(JSONdata);
                            $.ajax({
                                url: "/login",
                                type: "POST",
                                data: JSON.stringify(JSONdata),
                                contentType: "application/json",
                                dataType: "json",
                                success: function(data) {
                                    console.log(data);
                                    if (data.state) {
                                        Swal.fire({
                                            icon: "success",
                                            title: data.message,
                                            showDenyButton: false,
                                            showCancelButton: false,
                                            confirmButtonText: "確認",
                                            denyButtonText: `Don't save`,
                                            allowOutsideClick: false,
                                        }).then((result) => {
                                            $("#email_reg").removeClass("is-valid");
                                            $("#email_reg").addClass("is-invalid");
                                            $("#emailiv").html("重複帳號");
                                            flag_email_reg = false;
                                            location.href = data.data
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: data.message,
                                            showDenyButton: false,
                                            showCancelButton: false,
                                            confirmButtonText: "確認",
                                            denyButtonText: `Don't save`,
                                            allowOutsideClick: false,
                                        });
                                    }
                                },

                                error: function() {
                                    Swal.fire({
                                        title: "API介接錯誤?",
                                        text: "/login",
                                        icon: "error",
                                    });
                                },
                            });


                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: data.message,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: "確認",
                        denyButtonText: `Don't save`,
                        allowOutsideClick: false,
                    });
                }
            }

            //login  
            // email_login
            var flag_email_login = false;
            var flag_password_login = false;
            var flagLogin = flag_email_login && flag_password_login;

            function loginCheck() {
                flaglogin = flag_email_login && flag_password_login;
                if (flaglogin) {
                    $("#email_login").addClass("is-valid");
                    $("#email_login").removeClass("is-invalid");
                    $("#password_login").addClass("is-valid");
                    $("#password_login").removeClass("is-invalid");
                } else {
                    $("#email_login").addClass("is-invalid");
                    $("#email_login").removeClass("is-valid");
                    $("#password_login").addClass("is-invalid");
                    $("#password_login").removeClass("is-valid");
                }
            }
            $("#email_login").bind("input propertychange", function() {

                if (validateEmail(this.value)) {
                    flag_email_login = true;
                } else {
                    $("#email_login_iv").html("帳號密碼格式不符");
                    flag_email_login = false;
                }
                loginCheck();
            });
            // email_login
            $("#password_login").bind("input propertychange", function() {

                if ($(this).val().length > 2 && $(this).val().length < 21) {
                    flag_password_login = true;
                } else {
                    $("#email_login_iv").html("帳號密碼格式不符");
                    flag_password_login = false;
                }
                loginCheck();
            });
            $("#btn_login").click(function() {
                var flag = flag_email_login && flag_password_login;
                if (flag) {
                    var JSONdata = {};
                    JSONdata["email"] = $("#email_login").val();
                    JSONdata["password"] = $("#password_login").val();
                    console.log(JSONdata);
                    $.ajax({
                        url: "/login",
                        type: "POST",
                        data: JSON.stringify(JSONdata),
                        contentType: "application/json",
                        dataType: "json",
                        success: function(data, status) {
                            console.log(data);
                            console.log(status);
                            if (data.state) {
                                Swal.fire({
                                    icon: "success",
                                    title: data.message,
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: "確認",
                                    denyButtonText: `Don't save`,
                                    allowOutsideClick: false,
                                }).then((result) => {

                                    location.href = data.data
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: data.message,
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: "確認",
                                    denyButtonText: `Don't save`,
                                    allowOutsideClick: false,
                                });
                                $("#email_login_iv").html("登入失敗");
                                flag_email_login = false;
                                loginCheck();
                            }
                        },

                        error: function() {
                            Swal.fire({
                                title: "API介接錯誤?",
                                text: "/login",
                                icon: "error",
                            });
                        },
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "欄位錯誤",
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: "確認",
                        denyButtonText: `Don't save`,
                        allowOutsideClick: false,
                    });
                }
            })
            document.querySelectorAll('a.disabled').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // 阻止链接的默认行为
                });
            });
        });
    </script>
</body>

</html>