<!DOCTYPE html>
<html lang="en">
<head>
  <title>Альбом &mdash; {{$album->name}}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="icon" type="image/x-icon" href="/images/icons/favicon.ico">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="/css/albumscss/bootstrap.min.css">
  <link rel="stylesheet" href="/css/albumscss/magnific-popup.css">
  <link rel="stylesheet" href="/css/albumscss/jquery-ui.css">
  <link rel="stylesheet" href="/css/albumscss/owl.carousel.min.css">
  <link rel="stylesheet" href="/css/albumscss/owl.theme.default.min.css">

  <link rel="stylesheet" href="/css/albumscss/lightgallery.min.css">    

  <link rel="stylesheet" href="/css/albumscss/bootstrap-datepicker.css">

  <link rel="stylesheet" href="/fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="/css/albumscss/swiper.css">

  <link rel="stylesheet" href="/css/albumscss/aos.css">

  <link rel="stylesheet" href="/css/albumscss/style.css">


  </head>
<body>

  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    



    <header class="site-navbar py-3" role="banner">

      <div class="container-fluid">
        <div class="row align-items-center">

          <div class="col-6 col-xl-2" data-aos="fade-down">
            <h1 class="mb-0"><a href="index.html" class="text-white h2 mb-0">Альбомы</a></h1>
          </div>
          <div class="col-10 col-md-8 d-none d-xl-block" data-aos="fade-down">
            <nav class="site-navigation position-relative text-right text-lg-center" role="navigation">

              <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
                <li><a href="{{route('main_page')}}">Главная</a></li>
                <li class="active"><a href="{{route('albums_main')}}">Альбомы</a></li>
                
                @if (isset($_SESSION["username"]))
                
                  <li><a href="{{route('myaccount')}}">Личный кабинет</a></li>
                  <li><a href="{{route('logoutPagePost')}}">Выйти</a></li>
                @else
                <li><a href="{{route('loginPage')}}">Войти</a></li>
                  <li><a href="{{route('registrationPage')}}">Зарегистрироваться</a></li>
                @endif
              </ul>
            </nav>
          </div>

          

        </div>
      </div>
      
    </header>



    <div class="site-section"  data-aos="fade">
      <div class="container-fluid">

        <div class="row justify-content-center">

          <div class="col-md-7">
            <div class="row mb-5">
              <div class="col-12 ">
                <h2 class="site-section-heading text-center">{{$album->name}}</h2>
                <h1 class="hashtags-section text-center">Описание: {{$album->hashtag}}</h1>
                <h1 class="hashtags-section text-center">Хештеги: {{$hashtags}}</h1>
                <h1 class="hashtags-section text-center">Автор: {{$autor}}</h1>
              </div>
            </div>
          </div>

        </div>
        <div class="row" id="lightgallery">

        @foreach ($img as $im)
          <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 item" data-aos="fade" data-src="/images/{{$im->name}}">
            <a href="#"><img style="height:25rem ;width:27rem; object-fit: cover;" src="/images/{{$im->name}}"  class="img-fluid"></a>
          </div>
        @endforeach


        </div>
      </div>
    </div>


    
    
  </div>

  <script src="/js/albumsjs/jquery-3.3.1.min.js"></script>
  <script src="/js/albumsjs/jquery-migrate-3.0.1.min.js"></script>
  <script src="/js/albumsjs/jquery-ui.js"></script>
  <script src="/js/albumsjs/popper.min.js"></script>
  <script src="/js/albumsjs/bootstrap.min.js"></script>
  <script src="/js/albumsjs/owl.carousel.min.js"></script>
  <script src="/js/albumsjs/jquery.stellar.min.js"></script>
  <script src="/js/albumsjs/jquery.countdown.min.js"></script>
  <script src="/js/albumsjs/jquery.magnific-popup.min.js"></script>
  <script src="/js/albumsjs/bootstrap-datepicker.min.js"></script>
  <script src="/js/albumsjs/swiper.min.js"></script>
  <script src="/js/albumsjs/aos.js"></script>

  <script src="/js/albumsjs/picturefill.min.js"></script>
  <script src="/js/albumsjs/lightgallery-all.min.js"></script>
  <script src="/js/albumsjs/jquery.mousewheel.min.js"></script>

  <script src="/js/albumsjs/main.js"></script>
  
  <script>
    $(document).ready(function(){
      $('#lightgallery').lightGallery();
    });
  </script>

</body>
</html>