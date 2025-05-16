@extends('admin.layouts.layout')
@section('content')
    <div class="container my-5">
        <a href="{{route('admin.users.create')}}" class="btn btn-lg btn-primary">اضافة مستخدم</a>
       <div class="d-flex justify-content-center mb-2">
           <h2>إدارة المستخدمين</h2>
       </div>
        <div class="row">
            <div class="col">
                <table class="table text-center">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">الاسم</th>
                        <th scope="col">البريد الالكتروني</th>
                        <th scope="col">نوع المستخدم</th>
                        <th scope="col">الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($data as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->type == 'student' ? 'طالب' : 'مرشد اكاديمي'}}</td>
                        <td>
                            <a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-warning btn-lg">تعديل المستخدم</a>
                            <form action="{{route('admin.users.destroy',$user->id)}}" class="d-inline-block" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-lg btn-danger">حذف المستخدم</button>
                            </form>

                            <form action="{{route('admin.users.updateStatus',$user->id)}}" class="d-inline-block" method="post">
                                @csrf
                                @method('PUT')
                                @if($user->status === 'active')
                                <button type="submit" name="status" value="inactive" class="btn btn-lg btn-dark">تعطيل المستخدم</button>
                                @else
                                    <button type="submit" name="status" value="active" class="btn btn-lg btn-success">تفعيل المستخدم</button>

                                @endif
                            </form>

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
