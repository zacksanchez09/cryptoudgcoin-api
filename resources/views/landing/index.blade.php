<!DOCTYPE html>
<html lang="es" class="no-js">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta http-equiv="cleartype" content="on">
  <meta name="author" content="CryptoCoinUDG" />
  <meta name="copyright" content="CryptoCoinUDG" />
  <meta name="distribution" content="global" />
  <meta name="resource-type" content="document" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="keywords" content="CryptoUDGCoin - Aplicación para pago de servicios con Criptomoneda." />
  <meta name="robots" content="index,follow" />
  <meta name="description" content="CryptoUDGCoin - Aplicación para pago de servicios con Criptomoneda." />

  <title>Inicio - CryptoUDGCoin</title>
  <link rel="icon" type="image/png" href="{{asset('images/icon.png')}}" />

  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600|Roboto:400,400i,500" rel="stylesheet">
  <link rel="stylesheet" href="landing/assets/css/linearicons.css">
  <link rel="stylesheet" href="landing/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="landing/assets/css/bootstrap.css">
  <link rel="stylesheet" href="landing/assets/css/magnific-popup.css">
  <link rel="stylesheet" href="landing/assets/css/nice-select.css">
  <link rel="stylesheet" href="landing/assets/css/hexagons.min.css">
  <link rel="stylesheet" href="landing/assets/css/owl.carousel.css">
  <link rel="stylesheet" href="landing/assets/css/main.css">
</head>

<body>

  <header id="header">
    <div class="container main-menu">
      <div class="row align-items-center justify-content-between d-flex">
        <div id="logo">
          <h1 style="color:#fff;"><a href="{{ URL('/') }}">Crypto<strong style="color:#000;">UDG</strong>Coin</a></h1>
        </div>
        <nav id="nav-menu-container">
          <ul class="nav-menu">
            <li class="menu-active"><a href="{{ URL('/') }}">Inicio</a></li>
            <li><a href="#about">Acerca</a></li>
            <li><a href="#app">Diseño</a></li>
            <li><a href="#contact">Contacto</a></li>
            @auth
              <li><a href="{{ URL('/admin') }}"><i class="fa fa-user"></i></a></li>
            @else
              <li><a href="{{ URL('login') }}"><i class="fa fa-user"></i></a></li>
            @endif
          </ul>
        </nav>
      </div>
    </div>
  </header>

  <section class="home-banner-area">
    <div class="container">
      <div class="row fullscreen d-flex align-items-center justify-content-between">
        <div class="home-banner-content col-lg-6 col-md-6" align="center">
          <h1 style="color:#d5b04b;">
            Crypto<strong style="color:#000;">UDG</strong>Coin <img class="img-fluid" src="{{ asset('images/icon.png') }}" style="width: auto !important; height: auto; !important; max-width: 35%;">
          </h1>
          <br>
          <h4>Aplicación móvil que permite realizar diversos pagos a través de su propia Criptomoneda.</h4>
          <br>
          <div class="download-button d-flex flex-row justify-content-start">
              <div class="form-group row mb-0">
                  <div class="col-md-12" align="center">
                      <h2>Descarga nuestra App 📲</h2>
                      <br>
                  </div>
                  <div class="col-md-6" align="center">
                      <a href="" target="_blank">
                          <img src="{{ asset('images/app_store.png') }}" alt="App Store" style="width: auto !important; height: auto !important; max-width: 100%;">
                      </a>
                  </div>
                  <div class="col-md-6" align="center">
                      <a href="https://play.google.com/store/apps/details?id=com.cryptoudgcoin" target="_blank">
                          <img src="{{ asset('images/google_play.png') }}" alt="Google Play" style="width: auto !important; height: auto !important; max-width: 90%;">
                      </a>
                  </div>
              </div>
          </div>
        </div>
        <div class="banner-img col-lg-4 col-md-6" style="padding-top: 130px;">
          <img class="img-fluid" src="{{ asset('images/welcome.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
        </div>
      </div>
    </div>
  </section>

  <section class="about-area" id="about">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12 home-about-right">
          <h1>
            ¿Por qué CryptoUDGCoin?
          </h1>
          <p align="justify" style="color:#000;">
            La industria de las formas de pago digitales está un crecimiento exponencial mismo que hace que se elimine la necesidad de verificaciones por terceras personas, los pagos en efectivo y el registro de las transacciones y en un libro mayor digital a prueba de manipulaciones.
            Implementando e incentivando esta tecnología descentralizada y transparente llamada "Blockchain" CryptoUDGCoin tiene como propósito principal la innovación tecnológica del pago de los servicios estudiantiles a través de una "Criptomoneda" y una plataforma que permita la operación y realización de los mismos desde un dispositivo móvil.
          </p>
          <h1>
            ¿Cómo lo lograremos?
          </h1>
          <p align="justify" style="color:#000;">
          Gracias a la tecnología Blockchain. Nos provee una lista enlazada, construida con apuntadores Hash usados para grabar transacciones encriptadas de manera estructurada. Esta es descentralizada, distribuida y disponible para todos los participantes involucrados en la transacción. La blockchain privada remueve la necesidad de validaciones por terceras personas.
          Esta tecnología es la base fundamental de la operación de esta forma de pago y que además ha tenido un crecimiento exponencial en los últimos años, teniendo como pilares principales, la alta seguridad en las operaciones y el resguardo de activos digitales, creando una forma de pago rápida, segura y confiable.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="about-area" style="margin-top: -80px;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5 home-about-left" align="center">
          <img class="img-fluid" src="{{ asset('images/01.png') }}" alt="machine" style="width: auto !important; height: auto; !important; max-width: 80%;">
        </div>
        <div class="col-lg-6" align="center">
          <h1>
            Creemos que el interior embellece la arquitectura total.
          </h1>
        </div>
        <div class="col-lg-6 home-about-right home-about-right2" align="center">
          <h1>
            La facilidad de pagar un servicio escolar, nunca había sido tan sencillo.
          </h1>
        </div>
        <div class="col-lg-5 home-about-right2" align="center">
            <img class="img-fluid" src="{{ asset('images/02.png') }}" alt="machine" style="width: auto !important; height: auto; !important; max-width: 80%;">
        </div>
      </div>
    </div>
  </section>
  <br>

  <section class="fact-area">
    <div class="container">
      <div class="col-lg-12">
        <div class="section-title text-center">
          <h2>Qué queremos lograr</h2>
          <br>
          <p style="color:#000;">
          Para el primer año de lanzamiento oficial de la aplicación, tenemos algunos objetivos primordiales para lograr que sea un éxito total.
          </p>
        </div>
      </div>
      <div class="fact-box">
        <div class="row align-items-center">
          <div class="col single-fact">
            <h2>+10000</h2>
            <p>Monedas CryptoUDGCoin</p>
          </div>
          <div class="col single-fact">
            <h2>+500</h2>
            <p>Usuarios CryptoUDGCoin Diarios</p>
          </div>
          <div class="col single-fact">
            <h2>+5000</h2>
            <p>Transacciones por día</p>
          </div>
          <div class="col single-fact">
            <h2>1</h2>
            <p>Sola forma de pago</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="screenshot-area" id="app">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
          <div class="section-title text-center">
            <h2>Conoce nuestra aplicación</h2>
            <p style="color:#000;">
            Desarrollamos una aplicación con la fácilmente podrás realizar diversos pagos con su Criptomoneda gracias a su interfaz intuitiva y de fácil uso, toda la tecnología del Blockchain en la palma de tu mano.
            </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="owl-carousel owl-screenshot">
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/1.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/2.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/3.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/4.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/5.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/6.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/7.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/8.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/9.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/10.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/11.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/12.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/13.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/14.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/15.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/16.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/17.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/18.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/19.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/20.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/21.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/22.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/23.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/24.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/25.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/26.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/27.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/28.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/29.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/30.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/31.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
          <div class="single-screenshot">
            <img class="img-fluid" src="{{ asset('images/32.png') }}" style="width: auto !important; height: auto; !important; max-width: 100%;">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="about area" id="contact" style="padding-top: 60px;">
    <div class="container">
      <div class="row banner-content">
        <div class="col-lg-12 d-flex align-items-center justify-content-between">
          <div class="left-part">
            <h1>
              Contáctanos
            </h1>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>

  <section class="contact-page-area section-gap" style="margin-top: -40px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 d-flex flex-column address-wrap">
          <div class="single-contact-address d-flex flex-row">
            <div class="icon">
              <span class="lnr lnr-home"></span>
            </div>
            <div class="contact-details">
              <h5>Jalisco, México</h5>
              <p>Orgullo de pertenecer a la Universidad de Guadalajara.</p>
            </div>
          </div>
          <div class="single-contact-address d-flex flex-row">
            <div class="icon">
              <span class="lnr lnr-phone-handset"></span>
            </div>
            <div class="contact-details">
              <h5>+52 33 2828 7716</h5>
              <p>Disponibles las 24 horas, los 7 días de la semana.</p>
            </div>
          </div>
          <div class="single-contact-address d-flex flex-row">
            <div class="icon">
              <span class="lnr lnr-envelope"></span>
            </div>
            <div class="contact-details">
              <h5>contacto@cryptoudgcoin.com</h5>
              <p>¡Envíanos tu consulta en cualquier momento!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <form class="form-area" id="myForm" action="mail.php" method="post" class="contact-form text-right">
            <br>
            <div class="row">
              <div class="col-lg-6 form-group">
                <input name="name" placeholder="Tu nombre completo" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu nombre completo'"
                 class="mb-20 form-control" required="" type="text">

                <input name="email" placeholder="Tu correo electrónico" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$"
                 onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tu correo electrónico'" class="mb-20 form-control"
                 required="" type="email">

                <input name="subject" placeholder="Asunto" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Asunto'"
                 class="mb-20 form-control" required="" type="text">
              </div>
              <div class="col-lg-6 form-group">
                <textarea class="common-textarea form-control" name="message" placeholder="Mensaje" onfocus="this.placeholder = ''"
                 onblur="this.placeholder = 'Mensaje'" required=""></textarea>
              </div>
              <div class="col-lg-12 d-flex justify-content-between">
                <div class="alert-msg" style="text-align: left;"></div>
                <button class="primary-btn" style="float: right; color:#000">Enviar Mensaje</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer-area section-gap">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 single-footer-widget" align="center">
          <h4 style="font-size: 32px;">
            CryptoUDGCoin App.
            <br>
            <br>
            Disponible en App Store & Google Play.
          </h4>
        </div>
      </div>
      <div class="footer-bottom row align-items-center">
        <p class="footer-text m-0 col-lg-6 col-md-12" align="center">
        Copyright &copy; CryptoUDGCoin
            <script>document.write(new Date().getFullYear());</script>.
            Todos los derechos reservados.
        </p>
        <div class="col-lg-6 col-md-6 social-link">
          <div class="download-button d-flex flex-row justify-content-end">
            <div class="form-group row mb-0">
                <div class="col-md-6" align="center">
                    <a href="" target="_blank">
                        <img src="{{ asset('images/app_store.png') }}" alt="App Store" style="width: auto !important; height: auto !important; max-width: 100%;">
                    </a>
                </div>
                <div class="col-md-6" align="center">
                    <a href="https://play.google.com/store/apps/details?id=com.cryptoudgcoin" target="_blank">
                        <img src="{{ asset('images/google_play.png') }}" alt="Google Play" style="width: auto !important; height: auto !important; max-width: 95%;">
                    </a>
                </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
      <div class="row">
        <div class="col-md-6" align="center">
          <a style="color:#0f9aee;" href="{{ asset('Terms and Conditions - CryptoUDGCoin.pdf') }}" target="_blank">Términos y Condiciones</a>
        </div>
        <div class="col-md-6" align="center">
          <a style="color:#0f9aee;" href="{{ asset('Privacy Policy - CryptoUDGCoin.pdf') }}" target="_blank">Política de Privacidad</a>
        </div>
      </div>
    </div>
  </footer>

  <script src="landing/assets/js/vendor/jquery-2.2.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
   crossorigin="anonymous"></script>
  <script src="landing/assets/js/tilt.jquery.min.js"></script>
  <script src="landing/assets/js/vendor/bootstrap.min.js"></script>
  <script src="landing/assets/js/easing.min.js"></script>
  <script src="landing/assets/js/hoverIntent.js"></script>
  <script src="landing/assets/js/superfish.min.js"></script>
  <script src="landing/assets/js/jquery.ajaxchimp.min.js"></script>
  <script src="landing/assets/js/jquery.magnific-popup.min.js"></script>
  <script src="landing/assets/js/owl.carousel.min.js"></script>
  <script src="landing/assets/js/owl-carousel-thumb.min.js"></script>
  <script src="landing/assets/js/hexagons.min.js"></script>
  <script src="landing/assets/js/jquery.nice-select.min.js"></script>
  <script src="landing/assets/js/waypoints.min.js"></script>
  <script src="landing/assets/js/mail-script.js"></script>
  <script src="landing/assets/js/main.js"></script>
</body>

</html>
