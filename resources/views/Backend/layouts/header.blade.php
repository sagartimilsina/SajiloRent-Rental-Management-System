<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Sajilo Rent - @yield('title')</title>

    <meta name="description" content="" />


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/images/favicon.ico') }}" />
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="/sneat_backend/assets/vendor/fonts/boxicons.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/5489e1503c.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="/sneat_backend/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/sneat_backend/assets/vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/sneat_backend/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/sneat_backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/sneat_backend/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/sneat_backend/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/sneat_backend/assets/js/config.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Summernote Lite CSS and JS -->
    <link rel="stylesheet" href="/sneat_backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/sneat_backend/assets/vendor/libs/apex-charts/apex-charts.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">



    <style>
        :root {
            --primary: #008dd2 !important;
            --body-color: #e9f5fb !important;
            --secondary: #FF8000 !important;
            --color-purple: #b69cfc !important;
            --color-light-pink: #f7c6c7 !important;
            --main-primary: #1a2b4c !important;
        }

        .bg-color {
            background-color: var(--primary, rgba(18, 105, 155, 0.2)) !important;
        }

        .dropdown-menu {
            min-width: max-content;
        }

        .card {
            --bs-card-cap-padding-y: 0.8rem;
            --bs-card-cap-padding-x: 0.8rem;
        }

        .bg-primary,
        .btn-primary {
            background-color: var(--main-primary) !important;
            border-color: var(--main-primary) !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .bg-menu-theme .menu-inner>.menu-item.active>.menu-link {
            color: black !important;
            /* background-color: rgba(var(--secondary, 255, 128, 0), 0.2) !important; */
            background-color: var(--primary) !important;
        }

        .bg-menu-theme .menu-sub>.menu-item.active>.menu-link:not(.menu-toggle):before {
            background-color: var(--secondary, #FF8000) !important;
            border: 3px solid var(--body-color, #e9f5fb) !important;
        }

        .bs-toast {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            width: auto;
        }
    </style>
</head>

<body>
    <div id="toastMessage" class="bs-toast toast fade show " role="alert" aria-live="assertive" aria-atomic="true"
        style="display: none">
        <div class="toast-header">
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastBody">
        </div>
    </div>
