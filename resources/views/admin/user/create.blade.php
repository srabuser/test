@extends('admin.layouts.layout')
@section('content')
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100">
            <div class="col mx-auto">

                <div class="d-flex justify-content-center mb-2">
                    <h2>اضافة مستخدم جديد</h2>
                </div>
                <form action="{{route('admin.users.store')}}" method="post">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" for="email">الاسم</label>
                        <input type="text" name="name" id="name" value="{{old('name')}}"
                               class="form-control @error('name')is-invalid @enderror"/>
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="email">البريد الالكتروني</label>
                        <input type="email" name="email" id="email" value="{{old('email')}}"
                               class="form-control @error('email')is-invalid @enderror"/>
                        @error('email')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label class="form-label" for="type">نوع المستخدم</label>
                        <select class="form-select" id="type" name="type">
                            <option disabled selected>اختر نوع المستخدم</option>
                            <option value="student">طالب</option>
                            <option value="academic">مرشد اكاديمي</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password">كلمة المرور</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password')is-invalid @enderror"/>
                        @error('password')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password_confirmation">كلمة المرور</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"/>
                    </div>


                    <button type="submit" class="btn btn-primary btn-block mt-5">اضافة مستخدم جديد</button>
                </form>

            </div>
        </div>
    </div>
@endsection
