<!DOCTYPE html>
<html>
<?php
define('LINK', base_url().'management/');
define('ROOT_PATH', str_replace('index.php/', '', base_url()));
define('LAYOUT_PATH', ROOT_PATH . 'layout/management/');
define('STATIC_PATH', ROOT_PATH . 'statics/');
define('TITLE_NAME', 'สำนักหอสมุดมหาวิทยาลัยเชียงใหม่');
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= TITLE_NAME ?></title>
    <link rel="shortcut icon" href="#">
    <!-- JQUERY -->
    <script src="<?= STATIC_PATH ?>scripts/jquery-3.4.1.js"></script>

    <!-- JQUERY UI -->
    <link rel="stylesheet" href="<?= STATIC_PATH ?>scripts/jquery-ui/jquery-ui.min.css">
    <script src="<?= STATIC_PATH ?>scripts/jquery-ui/jquery-ui.min.js"></script>

    <!-- CORE THEME -->
    <script src="<?= STATIC_PATH?>scripts/core.js"></script>
    <script src="<?= STATIC_PATH?>scripts/script.min.js"></script>

    <!--Tiny Mac-->
    <script language="javascript" type="text/javascript"
        src="<?= STATIC_PATH?>scripts/tinymce/tinymce.js"></script>

    <!--validate-engine-->
    <script language="javascript" type="text/javascript"
            src="<?= STATIC_PATH?>scripts/validate-engine/languages/jquery.validationEngine-th.js"></script>
    <script language="javascript" type="text/javascript"
            src="<?= STATIC_PATH?>scripts/validate-engine/jquery.validationEngine.js"></script>
    <link rel="stylesheet" href="<?= STATIC_PATH?>scripts/validate-engine/validationEngine.jquery.css" media="all">

    <!-- calendar -->
    <link href="<?= STATIC_PATH ?>scripts/calendar/packages/core/main.css" rel='stylesheet'/>
    <link href="<?= STATIC_PATH ?>scripts/calendar/packages/daygrid/main.css" rel='stylesheet'/>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/core/main.js"></script>
    <script src="<?=STATIC_PATH ?>scripts/calendar/packages/interaction/main.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/daygrid/main.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/calendar/packages/core/locales/th.js"></script>

    <!-- SELECT2 -->
    <link rel="stylesheet" href="<?= STATIC_PATH ?>scripts/select2/css/select2.min.css">
    <script src="<?= STATIC_PATH ?>scripts/select2/js/select2.min.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/select2/js/i18n/th.js"></script>

    <!-- TABLEDND -->
    <link rel="stylesheet" href="<?= STATIC_PATH ?>scripts/tablednd/tablednd.css">
    <script src="<?= STATIC_PATH ?>scripts/tablednd/dist/jquery.tablednd.js"></script>

    <!-- ANGULARJS -->
    <script src="<?= STATIC_PATH ?>scripts/angularjs/angular.min.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/angularjs/angular-sanitize.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/angularjs/angular-animate.js"></script>

    <!-- sweet alert -->
    <script src="<?= STATIC_PATH ?>scripts/sweetalert/sweetalert.min.js"></script>
    <script src="<?= STATIC_PATH ?>scripts/sweetalert/sweetalert.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= STATIC_PATH ?>scripts/sweetalert/sweetalert.css" media="screen"/>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?= LAYOUT_PATH ?>styles/core.css">
    <link rel="stylesheet" type="text/css" href="<?= LAYOUT_PATH ?>styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="<?= LAYOUT_PATH ?>styles/style.css">

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

    <!-- apexcharts -->
    <script src="<?= STATIC_PATH ?>plugins/apexcharts/apexcharts.min.js"></script>

    <!-- CSS หลัก-->
    <link rel="stylesheet" href="<?= LAYOUT_PATH ?>styles/mainStyle.css">



</head>
<body link="<?= base_url()?>" class="d-flex flex-column h-100">
    <div class="header">
        <div class="header-left">
            <div class="menu-icon dw dw-menu"></div>
        </div>
        <div class="header-right">
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-name"><?= (!empty($session_data) ? '<i class="dw dw-user1"></i>&nbsp;&nbsp;'.$session_data['prename'].$session_data['fname'].' '.$session_data['lname'] : '')?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="<?= base_url()?>"><i class="icon-copy dw dw-link3"></i> ไปยังหน้าเว็บไซต์</a>
                        <a class="dropdown-item" href="<?= base_url().'management/ManageUser/form/'.$session_data['id']?>/profile"><i class="dw dw-user1"></i> แก้ไขโปรไฟล์</a>
                        <a class="dropdown-item" href="<?= base_url().'Login/logout'?>"><i class="dw dw-logout"></i> ออกจากระบบ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="<?= LINK?>">
                <img src="<?= LAYOUT_PATH?>images/deskapp-logo.svg" alt="" class="dark-logo">
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu icon-style-2">
                <ul id="accordion-menu">
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>
