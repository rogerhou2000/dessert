@extends("front.app")
@section("title")
<h1 class="text-white" style="text-decoration: underline;  text-underline-offset: 10px; ">首頁</h1>


<h1 class="text-white">home</h1>

@endsection

@section("content")
<style>
  .discount {
    position: relative;
  }

  .discount::before {
    content: "";
    position: absolute;
    top: 0;
    /* 線條從區塊的頂部開始 */
    left: 66%;

    width: 3px;
    /* 線條寬度 */
    height: 100%;
    /* 線條高度，覆蓋整個區塊的高度 */
    background-color: rgb(0, 0, 0);
    /* 黑色線條 */
  }
</style>

<section id="s1" style="margin-top: 71px;">
  <div class="container  ">
    <div class="row align-items-center ">
      <div
        class="col-md-5 bg-cover"
        style="
              background-image: url(/images/Frame13.png);
              height: 500px;
            ">
      </div>
      <div class="col-md-6 p-4 text-center ms-0 ms-md-5">
        <div class="h1 fw-900">
          西元2025年 <span class="text-success">新開</span>
        </div>
        <div class="h1 fw-900 mb-5">好吃的糕點
        </div>
        <p class="mb-4 h6">
          我們的糕點店以 新鮮、手作、創意 為核心理念，致力於為顧客帶來幸福
        </p>
        <p class="mb-4 h6">
          的味蕾體驗。我們的糕點堅持使用最高品質的天然食材，不添加人工色素
        </p>
        <p class="mb-4 h6">
          與防腐劑，讓每一口都充滿健康與安心。
        </p>
        <div class="row mt-5">
          <div class="col-md-3">
            <div class="h4 fw-900">會員人數</div>
            <div class="h1 fw-900 counter1 ">
              {{$member}}<span class="h5">人</span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="h4 fw-900">產品種類</div>
            <div class="h1 fw-900 counter2 ">
              {{$product}}<span class="h5">種</span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="h4 fw-900">訂單數量</div>
            <div class="h1 fw-900 counter3 ">
              {{$book}}<span class="h5">單</span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="h4 fw-900">營業額</div>
            <div class="h1 fw-900 counter4 ">
              {{$sum}}<span class="h5">元</span>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</section>
<section id="s3" style="margin-top: 71px;">
  <div class="container  ">
    <div class="row row-cols-lg-5 row-cols-2 align-items-center">
      <div class=" d-flex justify-content-center align-items-center text-center offset-3  offset-lg-0">
        <h2 class="fw-900">產品介紹
        </h2>
      </div>
      <div class="product justify-content-center align-items-center text-center    ">
        <a href="product/1" class="text-decoration-none fw-400 text-dark" style="
font-size: 16px;">
          <span class="d-block">蛋糕</span> <img src="images/Frame 27.png" class="img-fluid mt-1" alt=""></a>

      </div>
      <div class="product justify-content-center align-items-center text-center   "><a href="product/2" class="text-decoration-none fw-400 text-dark" style="
font-size: 16px;"><span class="d-block">麵包</span><img src="images/Frame 28.png" class="img-fluid mt-1" alt=""></a>

      </div>
      <div class="product justify-content-center align-items-center text-center  "><a href="product/4" class="text-decoration-none fw-400 text-dark" style="
font-size: 16px;"><span class="d-block">餅乾</span><img src="images/Frame 29.png" alt="" class="img-fluid mt-1"></a>

      </div>
      <div class="product justify-content-center align-items-center text-center "><a href="product/3" class="text-decoration-none fw-400 text-dark" style="
font-size: 16px;"><span class="d-block">派</span><img src="images/Frame 30.png" alt="" class="img-fluid mt-1"></a>

      </div>
    </div>

  </div>
</section>
<section id="s4" style="margin-top: 71px;">
  <div class="container">
    <div class="row flex-md-row-reverse row-cols-lg-3 row-cols-1 align-items-center">
      <div class="col d-flex justify-content-center align-items-center text-center ">
        <h2 class="fw-900">優惠介紹
        </h2>
      </div>
      <div class="col container p-3">
        <div
          class=" row  bg-cover justify-content-center align-items-center  "
          style="
            background-image: url(images/vip.png);
            background-size: cover;
            background-position: center center;
             height: 324px;
          ">

          <div
            class="col-11 my-3  rounded-3 discount"
            style="background-color:rgba(167, 163, 152, 0.66);height:90%; ">
            <div class="row h-100">
              <div class="col-8 d-flex flex-column justify-content-center align-items-center h-100">
                <p style="font-size: 28px;
font-weight: 700; color:rgb(19, 63, 50);">等級優惠</p>
                <p style="font-size: 20px;

font-weight: 500; color:rgb(9, 2, 34)">專為我們的尊貴熟客精心打造，獨享專屬等級優惠，讓您的每一筆消費都充滿驚喜，享受更豐富的美味與優惠！</p>
              </div>
              <div class="col-4 d-flex flex-column justify-content-center align-items-center h-100">
                <p style="color: #EB3333; margin: 0; font-size: 40px; font-style: italic;">10%</p>
                <p class=" h1 fw-bold " style="color: #A95C5C; margin: 0;">折扣</p>
              </div>
            </div>

          </div>

        </div>
      </div>
      <div class="col container p-3 ">
        <div
          class=" row  bg-cover justify-content-center align-items-center  "
          style="
            background-image: url(images/birthday.png);
            background-size: cover;
            background-position: center center;
            height: 324px;
          ">
          <div
            class="col-11   rounded-3 discount"
            style="background-color:rgba(167, 163, 152, 0.66); 
            height:90%;">
            <div class="row h-100">
              <div class="col-8 d-flex flex-column justify-content-center align-items-center h-100">
                <p style="font-size: 28px;
font-weight: 700; color:rgb(19, 63, 50);">生日優惠</p>
                <p style="font-size: 20px;

font-weight: 500; color:rgb(9, 2, 34)">當月當月壽星專屬！生日驚喜來了，優惠獨享限時放送，享受歡樂加倍！慶祝你的特別日子，盡情享受吧！</p>
              </div>
              <div class="col-4 d-flex flex-column justify-content-center align-items-center h-100">
                <p style="color: #EB3333; margin: 0; font-size: 40px; font-style: italic;">10%</p>
                <p class=" h1 fw-bold " style="color: #A95C5C; margin: 0;">折扣</p>
              </div>

            </div>



          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(function() {
    const counterUp = window.counterUp.default;

    const callback = (entries) => {
      entries.forEach((entry) => {
        const el = entry.target;

        if (entry.isIntersecting && !el.classList.contains("is-visible")) {
          counterUp(el, {
            duration: 1500,
            delay: 16,
          });
          el.classList.add("is-visible");
        }
      });
    }

    ;

    const IO = new IntersectionObserver(callback, {
      threshold: 1
    });

    const el1 = document.querySelector(".counter1");
    IO.observe(el1);
    const el2 = document.querySelector(".counter2");
    IO.observe(el2);
    const el3 = document.querySelector(".counter3");
    IO.observe(el3);
    const el4 = document.querySelector(".counter4");
    IO.observe(el4);
    $(".product").hover(function() {
      $(this).find("a").addClass("text-decoration-underline fw-700  h5");
    }, function() {
      $(this).find("a").removeClass("text-decoration-underline fw-700  h5");
    });

  });
</script>
@endsection