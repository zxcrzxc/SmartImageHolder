<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Личный кабинет</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
  	<link rel="icon" type="image/x-icon" href="/images/icons/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff" rel="stylesheet">

    <link rel="stylesheet" href="css/myacccss/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/myacccss/animate.css">
    <link rel="stylesheet" href="css/myacccss/owl.carousel.min.css">
    <link rel="stylesheet" href="css/myacccss/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/myacccss/magnific-popup.css">
    <link rel="stylesheet" href="css/myacccss/aos.css">
    <link rel="stylesheet" href="css/myacccss/ionicons.min.css">
    <link rel="stylesheet" href="css/myacccss/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/myacccss/jquery.timepicker.css">
    <link rel="stylesheet" href="css/myacccss/flaticon.css">
    <link rel="stylesheet" href="css/myacccss/icomoon.css">
    <link rel="stylesheet" href="css/myacccss/style.css">
  </head>
  <body>

	<div id="colorlib-page">
		<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
		<aside id="colorlib-aside" role="complementary" class="js-fullheight text-center">
			<h1 id="colorlib-logo"><a><span class="img" style="background-image: url(images/profile_images/{{$profile_image}});"></span>{{$dataFromDB->sname}} {{$dataFromDB->fname}} {{$dataFromDB->tname}}</a></h1>
			<nav id="colorlib-main-menu" role="navigation">
				<ul>
					<li><a href="{{route('main_page')}}">Главная</a></li>
					<li><a href="{{route('albums_main')}}">Альбомы</a></li>
					<li><a href="{{route('my_albums')}}">Мои альбомы</a></li>
					<li><a href="{{route('albums.create')}}">Создать альбом</a></li>
					<li><a href="{{route('changeMyAcc')}}">Изменить личные данные</a></li>
					<li><a href="{{route('logoutPagePost')}}">Выйти</a></li>
				</ul>
			</nav>
          </form>
				</div>
			</div>
		</aside>
		
		<div id="colorlib-main">
			<section class="ftco-section-no-padding bg-light">
				<div class="hero-wrap">
					<div class="overlay"></div>
					<div class="d-flex align-items-center js-fullheight">
						<div class="author-image text img d-flex">
							<section class="home-slider js-fullheight owl-carousel">
							@foreach ($profileIMGs as $image)
					      <div class="slider-item js-fullheight" style="background-image: url(images/profile_images/{{$image}});">
					      </div>
                			@endforeach
					    </section>
						</div>
						<div class="author-info text p-3 p-md-5">
							<div class="desc">
								<span class="subheading">О себе</span>
								<h1 class="big-letter">{{$dataFromDB->sname}} {{$dataFromDB->fname}}</h1>
								<h1 class="mb-4"><span>{{$dataFromDB->sname}} {{$dataFromDB->fname}}</span></h1>
								<p class="mb-4">{{$dataFromDB->info}}</p>
								<ul class="ftco-social mt-3">
		            </ul>
	            </div>
						</div>
					</div>
				</div>
			</section>
			
	    <footer class="ftco-footer ftco-bg-dark ftco-section">
	      <div class="container px-md-5">
	        <div class="row mb-5">
	          <div class="col-md">
	            <div class="ftco-footer-widget mb-4 ml-md-4">
	              <h2 class="ftco-heading-2">Недавние фотографии</h2>
	              <ul class="list-unstyled photo">

				  @foreach ($arrayOfImages as $image)
	                <li><a class="img" style="background-image: url(images/{{$image}});"></a></li>
					@endforeach
	              </ul>
	            </div>
	          </div>
	          <div class="col-md">
	             <div class="ftco-footer-widget mb-4">
	              <h2 class="ftco-heading-2">Архивы</h2>
	              <ul class="list-unstyled categories">

				  @foreach ($dateOfAlbums as $dateOfAlbum)
	              	<li>
						<a href="{{ route('album.show', ['id'=>$idOfArrays[$count], 'redirect2AllAlbums'=>true])}}">{{$dateOfAlbum}} 
								<span>{{$countOfImages[$count++]}}</span>
						</a>
					</li>
					@endforeach
	              </ul>
	            </div>
	          </div>
	        </div>
	      </div>
	    </footer>
		</div>
	</div>
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
  <script src="/js/loginjs/jquery.min.js"></script>
  <script src="/js/loginjs/jquery-migrate-3.0.1.min.js"></script>
  <script src="/js/loginjs/popper.min.js"></script>
  <script src="/js/loginjs/bootstrap.min.js"></script>
  <script src="/js/loginjs/jquery.easing.1.3.js"></script>
  <script src="/js/loginjs/jquery.waypoints.min.js"></script>
  <script src="/js/loginjs/jquery.stellar.min.js"></script>
  <script src="/js/loginjs/owl.carousel.min.js"></script>
  <script src="/js/loginjs/jquery.magnific-popup.min.js"></script>
  <script src="/js/loginjs/aos.js"></script>
  <script src="/js/loginjs/jquery.animateNumber.min.js"></script>
  <script src="/js/loginjs/bootstrap-datepicker.js"></script>
  <script src="/js/loginjs/jquery.timepicker.min.js"></script>
  <script src="/js/loginjs/scrollax.min.js"></script>
  
  <script src="/js/loginjs/google-map.js"></script>
  <script src="/js/loginjs/main.js"></script>
    
  </body>
</html>