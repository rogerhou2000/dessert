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


    <style>
        body {
            background-color: #F0E8D3;
        }

        .MBtn:hover {
            background-color: #B71C1C;
        }

        .logoutBtn:hover {
            background-color: #FB8C00;
        }
    </style>

    <script src="/js/jquery-3.7.1.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr("content")
            }
        });
    </script>
</head>

<body>
    <section id="s02" class="menu">
        <div class="container">
            <nav class="navbar navbar-expand-lg menu">
                <div class="container-fluid">

                    <div class="h1 pt-2 pb-1">控制台</div>
                    <button
                        class="navbar-toggler "
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('client/index') ? 'active disabled' : '' }} fs-5 fw-500"
                                    style="color: #4A4A4A;" aria-current="page" href="/client/index">
                                    購物車
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('client/book') ? 'active disabled' : '' }} fs-5 fw-500"
                                    style="color: #4A4A4A;" href="/client/book">
                                    用戶訂單
                                </a>
                            </li>
                        </ul>
                        <div>
                            <span
                                class="h4 fw-900 me-3 "
                                id="s02_username_showtext" style="color:rgb(60, 70, 69);">
                                歡迎會員:
                                <span class="h3" style="color:rgb(121, 65, 28);"> {{session()->get("member")->name}}</span>
                            </span>
                            @if(session()->get("member")->level>=100)
                            <button class="btn " id="MBtn" onclick="location.href='/manager/index';" style="background-color:#D32F2F;color:#FFFFFF">管理員後台</button>
                            @endif
                            <button class="btn " id="logoutBtn" style="background-color:#FFA726;color:#FFFFFF;">登出</button>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </section>


    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/counterup2@2.0.2/dist/index.js"></script>
    <script src="/js/wow.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield("content")



    <script>
        $('#logoutBtn').click(function() {
            $.ajax({
                url: '/logout',
                type: 'GET',
                success: function() {
                    Swal.fire({
                        title: '登出成功!',
                        icon: 'success'
                    }).then(() => {
                        sessionStorage.clear();
                        location.href = '/';
                    });
                },
                error: function() {
                    Swal.fire({
                        title: '登出失敗，請稍後重試。',
                        icon: 'error'
                    });
                }
            });
        });
    </script>
</body>

</html>