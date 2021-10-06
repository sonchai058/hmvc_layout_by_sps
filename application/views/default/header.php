<!DOCTYPE html>
<html class="h-100">
<?php
define('LINK', base_url());
define('ROOT_PATH', str_replace('index.php/', '', base_url()));
define('LAYOUT_PATH', ROOT_PATH . 'layout/default/');
define('STATIC_PATH', ROOT_PATH . 'statics/');
define('TITLE_NAME', '');
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title><?= TITLE_NAME ?></title>
    <meta name="description" content="<?= TITLE_NAME ?>">
    <meta name="title"
          content="">
    <meta name="description"
          content="">

    <script src="<?= STATIC_PATH ?>scripts/jquery-3.4.1.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/core.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/script.min.js"></script>

    <link rel="stylesheet" href="<?= STATIC_PATH ?>scripts/jquery-ui/jquery-ui.min.css">
    <script src="<?= STATIC_PATH ?>scripts/jquery-ui/jquery-ui.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?= LAYOUT_PATH ?>styles/core.css">
    <link rel="stylesheet" type="text/css" href="<?= LAYOUT_PATH ?>styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="<?= LAYOUT_PATH ?>styles/style.css">

    <script src="<?= STATIC_PATH ?>scripts/angularjs/angular.min.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/angularjs/angular-sanitize.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/angularjs/angular-animate.js"></script>

    <link href="<?= STATIC_PATH ?>scripts/calendar/packages/core/main.css" rel='stylesheet'/>
    <link href="<?= STATIC_PATH ?>scripts/calendar/packages/daygrid/main.css" rel='stylesheet'/>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/core/main.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/interaction/main.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/daygrid/main.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/core/locales/th.js"></script>

    <link rel="stylesheet" href="<?= STATIC_PATH ?>scripts/OwlCarousel2/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="<?= STATIC_PATH ?>scripts/OwlCarousel2/dist/assets/owl.theme.default.css">
    <script src="<?= STATIC_PATH ?>scripts/OwlCarousel2/dist/owl.carousel.js"></script>

    <link rel="stylesheet" href="<?= STATIC_PATH ?>scripts/select2/css/select2.min.css">
    <script src="<?= STATIC_PATH ?>scripts/select2/js/select2.min.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/select2/js/i18n/th.js"></script>

    <link href="<?= LAYOUT_PATH ?>fonts/fontawesome5.15/css/all.css" rel="stylesheet">

    <link href="<?= STATIC_PATH ?>scripts/calendar/packages/core/main.css" rel='stylesheet'/>
    <link href="<?= STATIC_PATH ?>scripts/calendar/packages/daygrid/main.css" rel='stylesheet'/>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/core/main.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/interaction/main.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/daygrid/main.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/core/locales/th.js"></script>

    <link href="<?= STATIC_PATH ?>scripts/fancybox/dist/jquery.fancybox.min.css" rel='stylesheet'/>
    <script src="<?= STATIC_PATH ?>scripts/fancybox/dist/jquery.fancybox.min.js"></script>


    <!-- datepicker -->
    <script src="<?= STATIC_PATH ?>scripts/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/bootstrap-datepicker/js/bootstrap-datepicker-thai.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js"></script>
    <link href="<?= STATIC_PATH ?>scripts/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel='stylesheet'/>

    <!-- DATETIMEPICKER -->
    <link rel="stylesheet" href="<?= STATIC_PATH ?>scripts/datetimepicker/jquery.datetimepicker.css">
    <script src="<?= STATIC_PATH ?>scripts/datetimepicker/build/jquery.datetimepicker.full.js"></script>

    <!-- asColorPicker -->
    <link rel="stylesheet" type="text/css" href="<?= STATIC_PATH ?>plugins/jquery-asColorPicker/dist/css/asColorPicker.css">
    <script src="<?= STATIC_PATH ?>plugins/jquery-asColor/dist/jquery-asColor.js"></script>
    <script src="<?= STATIC_PATH ?>plugins/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="<?= STATIC_PATH ?>plugins/jquery-asColorPicker/jquery-asColorPicker.js"></script>
    
    <link rel="stylesheet" href="<?= LAYOUT_PATH ?>styles/aos.css">
    <script src="<?= STATIC_PATH ?>scripts/aos/aos.js"></script>

    <script src="<?= STATIC_PATH ?>scripts/paginationMagic.js"></script>

    <link rel="stylesheet" href="<?= LAYOUT_PATH ?>styles/mainStyle.css">

    <link rel="stylesheet" href="<?= STATIC_PATH ?>styles/animate.css">

    <script src="<?= STATIC_PATH ?>plugins/cookie-consent-bar-message/src/jquery.cookieMessage.js"></script>
</head>

<body link="<?= LINK ?>" class="d-flex flex-column h-100">
<main>
    <div class="blockBackgroup"></div>
    <div class="bgBarHeader">
        <div class="container ">
            <nav class="navbar navbar-expand-lg navbarSbs">
              <a class="navbar-brand" href="#">
                <img src="<?= LAYOUT_PATH . 'images/logo_sbs.png' ?>" class="logoWeb" alt="logoWeb">
              </a>
              <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse navbar-collapseSbs" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                  <!-- <li class="nav-item active">
                    <a href="#">เข้าสู่ระบบ</a>
                  </li> -->
                </ul>
              </div>
            </nav>
        </div>
    </div>
