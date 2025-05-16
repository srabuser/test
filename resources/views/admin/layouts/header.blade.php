<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
    />
    <!-- MDB -->
    <link
        href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@9.0.0/css/mdb.rtl.min.css"
        rel="stylesheet"
    />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.min.css">
    <title>لوحة التحكم</title>
</head>
<body>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <!-- Container wrapper -->
    <div class="container">
        <!-- Toggle button -->
        <button
            data-mdb-collapse-init
            class="navbar-toggler"
            type="button"
            data-mdb-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-2 mt-lg-0" href="#">
               لوحة التحكم
            </a>
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.index')}}">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.users.index')}}">المستخدمين</a>
                </li>
            </ul>
            <!-- Left links -->
        </div>
        <!-- Collapsible wrapper -->

        <!-- Right elements -->
        <div class="d-flex align-items-center">

            <a href="#" class="btn btn-lg btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">تسجيل الخروج</a>
            <form action="{{route('admin.logout')}}" id="logout-form" method="post" class="d-none">
                {{ csrf_field() }}
            </form>
        </div>
        <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->
@if(Session::has('success'))
    <script>
        Swal.fire({
            position: "center",
            icon: "success",
            title: "{{Session::get('success')}}",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif
