<nav class="bg-gradient-to-r from-blue-500 to-indigo-600 shadow-md fixed top-0 w-full z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo Section -->
        <div class="flex items-center">
            <a href="#" class="text-3xl font-bold text-white hover:text-gray-200 transition duration-300 flex items-center">
                <img style="border-radius: 10%; width: 70px;" src="{{asset('logo.jpg')}}" alt="Logo" class="mr-2">
            </a>
        </div>

        <!-- Desktop Menu Items -->
        <div class="hidden md:flex items-center space-x-8">
            <a href="{{route('home')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4"> البرنامج</a>
            <a href="{{route('trtebh')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">ترتيبة</a>
            <a href="{{route('requirements')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">المتطلبات</a>
            <a href="{{route('calcGrade')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">حساب المعدل</a>
            <a href="{{route('help')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">المساعدة</a>
            @auth
            @if(auth()->user()->type === 'academic')
                <a href="{{route('academic.appointments')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">المرشد الاكاديمي</a>
            @endif
            @endauth
            @guest
                <a href="{{route('register')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">التسجيل</a>

            @endguest
        </div>

        <!-- Mobile Menu Toggle Button -->
        <div class="md:hidden flex items-center">
            <button id="mobile-menu-button" class="text-white text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="md:hidden hidden bg-gradient-to-r from-blue-500 to-indigo-600">
        <div class="flex flex-col items-center py-4">
            <a href="{{route('home')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">البرنامج</a>
            <a href="{{route('trtebh')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">ترتيبة</a>
            <a href="{{route('requirements')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">المتطلبات</a>
            <a href="{{route('help')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">المساعدة</a>
            @auth
                @if(auth()->user()->type === 'academic')
            <a href="{{route('academic.appointments')}}" class="text-white text-lg font-medium hover:text-blue-200 transition duration-300 py-2 px-4">المرشد الاكاديمي</a>
                @endif
            @endauth
        </div>
    </div>
</nav>
