@extends("manager.app")
@section("content")
<div class="container mt-5">
    <div class="row mt-5">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card h-100 shadow">
                <div class="card-body d-flex align-items-center">
                    <i
                        class="fa-solid fa-users fa-4x text-danger d-none d-md-block"></i>
                    <div class="text-center w-100">
                        <div class="h5 fw-900">會員人數</div>
                        <div class="h3 fw-900" id="count_member">{{$member}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card h-100 shadow">
                <div class="card-body d-flex align-items-center">
                    <i
                        class="fa-solid fa-cake-candles fa-4x text-danger d-none d-md-block"></i>
                    <div class="text-center w-100">
                        <div class="h5 fw-900">商品數量</div>
                        <div class="h3 fw-900">{{$product}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card h-100 shadow">
                <div class="card-body d-flex align-items-center">
                    <i
                        class="fa-solid fa-money-bill-1-wave fa-4x text-success d-none d-md-block"></i>
                    <div class="text-center w-100">
                        <div class="h5 fw-900">訂單數量</div>
                        <div class="h3 fw-900">{{$book}}</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card h-100 shadow">
                <div class="card-body d-flex align-items-center">
                    <i
                        class="fa-solid fa-money-bill-1-wave fa-6x text-005 d-none d-md-block"></i>
                    <div class="text-center w-100">
                        <div class="h3 fw-900">營業額</div>
                        <div class="h4 fw-900">{{$sum}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3 gy-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header h4 text-bg-success fw-900">
                    會員來源分布統計
                </div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header h4 text-bg-warning fw-900">
                    會員年齡分布統計
                </div>
                <div class="card-body">
                    <canvas id="myChart02"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h4 text-bg-info fw-900">
                    產品銷量統計
                </div>
                <div class="card-body">
                    <canvas id="myChart03"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var mychart;
    var mychart02;
    var mychart03;
    var age = JSON.parse(`{!! json_encode($age) !!}`); // 確保資料是有效的 JSON 格式
    var region = JSON.parse(`{!! json_encode($region) !!}`); // 確保資料是有效的 JSON 格式
    var productAmount = JSON.parse(`{!! json_encode($productAmount) !!}`);
    $(function() {
        // 基本圖表設定
        console.log(age);
        console.log(region);
        const ctx = document.getElementById("myChart");
        const ctx02 = document.getElementById("myChart02");
        const ctx03 = document.getElementById("myChart03");

        mychart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: region.map(item => item.city),
                datasets: [{
                    label: "城市人數統計",
                    data: region.map(item => item.city_count),
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(54, 162, 235)",
                        "rgb(255, 20, 186)",
                        "rgb(100, 205, 10)",
                        "rgb(0, 205, 86)",
                        "rgb(255, 63, 200)",
                    ],
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        mychart02 = new Chart(ctx02, {
            type: "line",
            data: {
                labels: age.map(item => item.age_group),
                datasets: [{
                    label: "年齡組人數",
                    data: age.map(item => item.group_count),
                    backgroundColor: "rgb(54, 162, 235)",
                    borderColor: "rgb(54, 162, 235)",
                    fill: false,
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
        mychart03 = new Chart(ctx03, {
            type: "bar",
            data: {
                labels: productAmount.map(item => item.itemName),
                datasets: [{
                    label: "產品銷量統計",
                    data: productAmount.map(item => item.productAmount),
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(54, 162, 235)",
                        "rgb(255, 20, 186)",
                        "rgb(100, 205, 10)",
                        "rgb(0, 205, 86)",
                        "rgb(255, 63, 200)",
                    ],
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    });
</script>
@endsection