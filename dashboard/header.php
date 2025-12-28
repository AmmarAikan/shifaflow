<!-- <?php
require_once('validate_sess.php');
?> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!--My Css -->
    <link rel="stylesheet" href="./css/mystyle.css">
    
</head>

<body >

    <!-- navigator -->
    <nav class=" navbar navbar-expand-lg bg-body-tertiary"
        style="background-color: #091629 ; direction: rtl;z-index: 1000;">
        <div class="container-fluid">
            <a class="navbar-brand " href="#" style="color: white;">
                <h2>دار الشفاء</h2>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class=" nav-link active " aria-current="page" href="index.php"
                            style="color: white;">الرئيسية</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="featuers_us.php" style="color: white;">مميزاتنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.php" style="color: white;">التواصل</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="about_us.php" style="color: white;">عن العيادة</a>
                    </li>
                    <!-- <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true"style="color: white;">Disabled</a>
          </li> -->
                </ul>
            </div>

           
          
        <div class="navbar-nav">
        <!-- <a class="nav-link px-3" href="./patientPage.php" style="color:white;">صفحتي </a> -->
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="./sign_out.php" style="color:white;">خروج </a>
                
            </div>
            
        </div>
    </nav>
    <!-- navigator -->




<!-- <!DOCTYPE html>
<html lang="en"> -->

<!-- <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Dashboard</title>
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        } -->
    <!-- /* </style> */ -->
    <!-- Custom styles for this template -->
    <!-- <link href="./css/dashboard.css" rel="stylesheet"> -->
    <!-- ckeditor -->
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
</head> -->

<!-- <body onload="senon();">
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <?php
            if($_SESSION['adminName'])
            {
                $name = $_SESSION['adminName'];
                echo "<span class='navbar-brand col-md-3 col-lg-3 me-0 px-2 fs-6'>Welcome: $name</span>";
            }
        ?>        
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="form-control text-center form-control-dark w-100 rounded-0 border-0">News Website</h1>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="./sign_out.php">Sign out</a>
            </div>
        </div>
    </header> -->