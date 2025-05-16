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
        href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@9.0.0/css/mdb.min.css"
        rel="stylesheet"
    />
    <title>لوحة التحكم</title>
</head>
<body>
<div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="row w-100">
                <div class="col mx-auto">

                    <div class="d-flex justify-content-center mb-2">
                        <h2>تسجيل الدخول ( لوحة التحكم )</h2>
                    </div>
                    <form action="{{route('admin.login')}}" method="post">
                        @csrf

                        <div  class=" mb-4">
                            <label class="form-label" for="email">البريد الالكتروني</label>
                            <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control @error('email')is-invalid @enderror" />
                            @error('email')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>



                        <div class=" mb-4">
                            <label class="form-label" for="password">كلمة المرور</label>
                            <input type="password" name="password" id="password" class="form-control @error('password')is-invalid @enderror" />
                            @error('password')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>



                        <button  type="submit" class="btn btn-primary btn-block mt-5">تسجيل الدخول</button>
                    </form>

                </div>
            </div>
        </div>


<!-- MDB -->
<script
    type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@9.0.0/js/mdb.umd.min.js"
></script>
</body>
</html>

