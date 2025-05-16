<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل حساب جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        #chatButton:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50">

@include('layouts.nav')

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        var menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>

<section id="register" style="margin-top: 140px;" class="py-2 px-4 bg-gray-100">
    <div class="max-w-6xl mx-auto text-center">
        <div class="mb-5">
            <div class="flex flex-col items-center space-y-6">

                <h1 class="text-2xl font-bold text-green-600">إنشاء حساب جديد</h1>

                <form method="POST" action="{{ route('register') }}" class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">الاسم الكامل</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="w-full border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-bold mb-2">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-bold mb-2">كلمة المرور</label>
                        <input type="password" id="password" name="password"
                               class="w-full border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">تأكيد كلمة المرور</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-md w-full transition duration-300 transform hover:scale-105">
                        تسجيل
                    </button>
                </form>

            </div>
        </div>
    </div>
</section>

</body>
</html>
