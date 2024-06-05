<!DOCTYPE html>
<html lang="en">
<head>
  <title>Главная</title>
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
                <li class="active"><a href="{{route('main_page')}}">Главная</a></li>
                <li><a href="{{route('albums_main')}}">Альбомы</a></li>
                
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
                <h2 class="site-section-heading text-center">Альбомы</h2>
              </div>
            </div>
          </div>

        </div>
        
        <div class="row mb-5">
          <div class="col-md-7">
            <img src="images/img_2.jpg" alt="Images" class="img-fluid">
          </div>
          <div class="col-md-4 ml-auto">
            <h3 class="text-white">Описание сайта</h3>
            <p>Добро пожаловать на наш сайт для хранения альбомов! Здесь вы можете создавать альбомы, добавлять к ним описания, присваивать хештеги для удобной навигации и использовать удобный поиск по дате и хештегам. Независимо от того, являетесь ли вы профессиональным фотографом, любителем сохранять воспоминания или просто цените красоту изображений, наш сайт поможет вам управлять вашей коллекцией альбомов легко и эффективно.</p>
            <p>Создавайте, редактируйте, ищите и делитесь своими воспоминаниями с миром на нашем удобном сайте для хранения альбомов!</p>
          </div>
        </div>


        <div class="row site-section">
          <div class="col-md-6 col-lg-6 col-xl-4 text-center mb-5">
            <img src="images/images_4_main/FZTP5cNX1Qg.jpg" alt="Image" style="height:20rem;width:20rem; object-fit: cover;" class="img-fluid w-50 rounded-circle mb-4">
            <h2 class="font-weight-light mb-4">Скрипченко Арсений</h2>
            <p class="mb-4">Знаете, я всегда хотел иметь возможность удобного хранения фотографий в интернете, но уже существующие решения меня не устраивали. Если говорить об этом приложении, то я с уверенностью могу сказать, что на сегодняшний день оно является лучшим в своём роде. Удобный и интуитивно понятный интерфейс делает пользовательский “экспириенс” очень увлекательным всем советую!</p>

          </div>
          <div class="col-md-6 col-lg-6 col-xl-4 text-center mb-5">
            <img src="images/images_4_main/hpJs49HamoQ.jpg" alt="Image" style="height:20rem; object-fit: cover;" class="img-fluid w-50 rounded-circle mb-4">
            <h2 class="font-weight-light mb-4">Чудакова Анна</h2>
            <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur ab quas facilis obcaecati non ea, est odit repellat distinctio incidunt, quia aliquam eveniet quod deleniti impedit sapiente atque tenetur porro?</p>
        
          </div>
          <div class="col-md-6 col-lg-6 col-xl-4 text-center mb-5">
            <img src="images/images_4_main/tlaxkk1UZzQ.jpg" alt="Image" style="height:20rem; object-fit: cover;" class="img-fluid w-50 rounded-circle mb-4">
            <h2 class="font-weight-light mb-4">Фещенко Игорь</h2>
            <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur ab quas facilis obcaecati non ea, est odit repellat distinctio incidunt, quia aliquam eveniet quod deleniti impedit sapiente atque tenetur porro?</p>
          
          </div>
        </div>
      </div>
    </div>

  </div>

<script src="js/albumsjs/jquery-3.3.1.min.js"></script>
<script src="js/albumsjs/jquery-migrate-3.0.1.min.js"></script>
<script src="js/albumsjs/jquery-ui.js"></script>
<script src="js/albumsjs/popper.min.js"></script>
<script src="js/albumsjs/bootstrap.min.js"></script>
<script src="js/albumsjs/owl.carousel.min.js"></script>
<script src="js/albumsjs/jquery.stellar.min.js"></script>
<script src="js/albumsjs/jquery.countdown.min.js"></script>
<script src="js/albumsjs/jquery.magnific-popup.min.js"></script>
<script src="js/albumsjs/bootstrap-datepicker.min.js"></script>
<script src="js/albumsjs/swiper.min.js"></script>
<script src="js/albumsjs/aos.js"></script>

<script src="js/albumsjs/picturefill.min.js"></script>
<script src="js/albumsjs/lightgallery-all.min.js"></script>
<script src="js/albumsjs/jquery.mousewheel.min.js"></script>

<script src="js/albumsjs/main.js"></script>

<script>
  $(document).ready(function(){
    $('#lightgallery').lightGallery();
  });
</script>

</body>
</html>