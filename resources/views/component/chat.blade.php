@guest
    <div id="loginPopup" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h3 class="text-center text-xl font-bold mb-4">التسجيل</h3>
            <form id="loginForm">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-semibold text-gray-700">البريد الالكتروني</label>
                    <input type="text" id="email" class="w-full p-2 mt-2 border border-gray-300 rounded-lg"
                           placeholder="البريد الالكتروني" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700">كلمة المرور</label>
                    <input type="password" id="password" class="w-full p-2 mt-2 border border-gray-300 rounded-lg"
                           placeholder="ادخل كلمة المرور" required>
                </div>
                <div id="error-message" class="text-red-500 text-sm mb-4 hidden"></div>
                <div class="flex justify-between">
                    <button type="button" id="submitButton" class="bg-blue-500 text-white p-2 rounded-lg">تسجيل الدخول
                    </button>
                    <button type="button" id="closePopup" class="bg-red-500 text-white p-2 rounded-lg">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
@endguest

@auth


    <div id="chatbox" class="fixed bottom-0 right-0  w-[350px] h-[75vh] bg-white hidden chatboxs" style="z-index: 999">

        <!-- Header -->
        <div class="chatbox-header text-right font-bold text-2xl p-4 bg-gray-800 text-white flex items-center justify-between">
            <img src="{{asset('logo.jpg')}}" width="50" >
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <span id="chatId" class="text-sm mx-2">ID: {{ Auth::user()->id }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center text-white hover:text-red-500">
                        <i class="fas fa-times cursor-pointer"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Body -->
        <div id="chatBody" class="chatbox-body h-[calc(75vh-150px)] overflow-y-auto p-4 space-y-2">

            <p class="message received bg-gray-100 p-2 rounded">مرحبًا! كيف يمكنني مساعدتك؟</p>
            <p class="message received bg-gray-100 p-2 rounded">عند السؤال عن مادة, نرجوا كتابة اسم المادة او رمز المادة فقط</p>
            <p class="message received bg-gray-100 p-2 rounded">اكتب "حجز موعد" لحجز موعد مع المرشد الأكاديمي</p>

            @foreach ($messages as $message)
                <p class="message sent bg-blue-100 text-right p-2 m-2 rounded-md">{{ $message->message }}</p>

                @foreach($message->answer as $item)
                    @if ($item['type'] === 'course')
                        <div class="message received bg-gray-50 p-2 rounded border">
                            📚 <strong>كورس: {{ $item['name'] }}</strong><br>
                            الكود: {{ $item['course_code'] }}<br>
                            عدد الساعات: {{ $item['units'] }}<br>
                            المتطلبات: {{ $item['requirement'] }}
                        </div>
                    @elseif ($item['type'] === 'appointment')
                        <div class="message received bg-gray-50 p-2 rounded border">
                            🗓 <strong>موعد:</strong><br>
                            يوم: {{ $item['day'] }}<br>
                            الوقت: {{ $item['time'] }}<br>
                            الحالة: {{ $item['available'] ? 'متاح' : 'غير متاح' }}
                            <div class="mt-2">
                                @if($item['available'])
                                    <button class="px-3 py-1.5 bg-green-500 text-white rounded hover:bg-green-600 text-sm"
                                            onclick="changeStatus({{ $item['id'] }})">
                                        متاح
                                    </button>
                                @else
                                    <button class="px-3 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                        غير متاح
                                    </button>
                                @endif
                            </div>
                        </div>
                    @elseif ($item['type'] === 'rule')
                        <div class="message received bg-gray-50 p-2 rounded border">
                            📖 <strong>{{ $item['category'] }}:</strong><br>
                            {{ $item['answer'] }}
                        </div>
                    @elseif ($item['type'] === 'default')
                        <div class="message received bg-gray-50 p-2 rounded border">
                            {{ $item['message'] }}
                        </div>
                    @endif
                @endforeach

            @endforeach
        </div>

        <!-- Footer -->
        <div class="chatbox-footer flex items-center p-3 border-t">
            <input type="text" placeholder="أكتب رسالتك..." id="chatInput" class="flex-1 border rounded px-3 py-2 mr-2">
            <button id="sendMessage" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                إرسال
            </button>
        </div>

    </div>


@endauth



<script>
    const chatButton = document.getElementById('chatButton');
    const chatbox = document.getElementById('chatbox');
    const loginPopup = document.getElementById('loginPopup');
    const closePopupButton = document.getElementById('closePopup');
    const closeChatButton = document.getElementById('closeChat');
    const chatInput = document.getElementById('chatInput');
    const chatBody = document.getElementById('chatBody');
    const sendMessageButton = document.getElementById('sendMessage');

    let isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';

    chatButton.addEventListener('click', function () {
        @auth
        chatbox.classList.remove('hidden');
        scrollToBottom();
        @else
        loginPopup.classList.remove('hidden');
        @endauth
    });



    closePopupButton.addEventListener('click', function () {
        loginPopup.classList.add('hidden');
    });

    closeChatButton.addEventListener('click', function () {
        chatbox.classList.add('hidden');
    });

    document.body.addEventListener('click', function (event) {
        if (!chatButton.contains(event.target) && !chatbox.contains(event.target)) {
            chatbox.classList.add('hidden');
        }
        if (!loginPopup.contains(event.target) && !chatButton.contains(event.target)) {
            loginPopup.classList.add('hidden');
        }
    });

    sendMessageButton.addEventListener('click', function () {
        const message = chatInput.value;
        if (message.trim() !== '') {
            const newMessage = document.createElement('p');
            newMessage.classList.add('message', 'sent', 'bg-green-500', 'text-white', 'p-2', 'rounded-lg', 'mb-2');
            newMessage.textContent = message;
            chatBody.appendChild(newMessage);
            chatInput.value = '';
        }
    });


</script>


<script>
    document.getElementById('submitButton').addEventListener('click', function (event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (email && password) {
            fetch("{{ route('login') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ email, password })
            })
                .then(response => {
                    console.log(response);

                    if (response.redirected) {
                        window.location.href = response.url;
                        return;
                    }

                    return response.json();

                })
                .then(data => {
                    console.log(data);
                    if (data?.status === 'error' || data?.status === 'isActive') {
                        document.getElementById('error-message').innerText = data.message;
                        document.getElementById('error-message').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('error-message').innerText = 'حدث خطأ. يرجى المحاولة لاحقًا.';
                    document.getElementById('error-message').classList.remove('hidden');
                });
        } else {
            document.getElementById('error-message').innerText = 'يرجى ملء جميع الحقول.';
            document.getElementById('error-message').classList.remove('hidden');
        }
    });

</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {


        function sendMessage() {
            var question = $('#chatInput').val().trim();

            if (question === '') return;


            $('#chatBody').append('<p class="message sent">' + question + '</p>');

            $('#chatInput').val('');

            $.ajax({
                url: '{{ route("chat.ask") }}',
                method: 'POST',
                data: {
                    question: question,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log(response);

                    if (Array.isArray(response)) {
                        response.forEach(item => {
                            let message = '';

                            if (item.type === 'appointment') {
                                let buttonHtml = item.available == 0
                                    ? '<button class="px-3 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 text-sm">غير متاح</button>'
                                    : '<button class="px-3 py-1.5 bg-green-500 text-white rounded hover:bg-green-600 text-sm" onclick="changeStatus(' + item.id + ')">متاح</button>';

                                message = `🗓 <strong>موعد:</strong> يوم: ${item.day}، الساعة: ${item.time}<br>${buttonHtml}`;
                            }

                            if (item.type === 'course') {
                                message = `📚 <strong>المادة: ${item.name}</strong><br>الكود: ${item.course_code}<br>عدد الساعات: ${item.units}<br>المتطلبات: ${item.requirement}`;
                            }

                            if (item.type === 'rule') {
                                message = `📖 <strong>${item.category}:</strong><br>${item.answer}`;
                            }

                            if (item.type === 'default') {
                                message = `<strong>${item.message}</strong>`;
                            }

                            $('#chatBody').append(`<p class="message received">${message}</p>`);
                        });
                    } else {
                        $('#chatBody').append('<p class="message received">' + response + '</p>');
                    }

                    scrollToBottom();
                },
                error: function () {
                    $('#chatBody').append('<p class="message received">عذرًا، حدث خطأ.</p>');
                    scrollToBottom();
                }
            });
        }


        $('#sendMessage').click(sendMessage);


        $('#chatInput').keypress(function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                sendMessage();
            }
        });


        scrollToBottom()

    });


    function scrollToBottom() {
        let chatBody = document.getElementById('chatBody');
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    scrollToBottom()


</script>


<script>
    function changeStatus(id) {
        let url = '{{ route("bookAppointment", ":id") }}'.replace(':id', id);

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({id: id})
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);

                if (data.message) {
                    alert(data.message);
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
