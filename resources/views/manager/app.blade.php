<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/css/all.min.css">
  <link rel="stylesheet" href="/css/my.css">
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/MarkerCluster.css">
  <script src="/js/jquery-3.7.1.min.js"></script>
  <style>
        body {
            background-color: #F0E8D3;
        }

    </style>

  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr("content")
      }
    });
  </script>
</head>

<body>
  <section id="s02" class="bg-dark">
    <div class="container">
      <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <div class="h1">控制台</div>
          </a>
          <button
            class="navbar-toggler"
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
                <a class="nav-link {{ request()->is('manager/index') ? 'active disabled' : '' }}"   href="/manager/index">首頁</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('manager/client/index') ? 'active disabled' : '' }}" href="/manager/client/index">用戶管理</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('manager/product/*') ? 'active disabled' : '' }}" href="/manager/product/index">產品管理</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is('manager/book/*') ? 'active disabled' : '' }}" href="/manager/book/index">訂單管理</a>
              </li>
            </ul>

            <div>
              <span
                class="h4 text-success fw-900 me-3 "
                id="s02_username_showtext">
                歡迎會員:
                <span class="h3 text-danger">{{session()->get("member")->name}}</span>
              </span>
              <button class="btn btn-danger" id="logoutBtn">登出</button>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </section>


  <script src="\js\bootstrap.bundle.min.js"></script>
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
            title: '登出失敗!',
            icon: 'error'
          });
        }
      });
    });
  </script>
</body>

</html>