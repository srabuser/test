
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>برنامج الشات بوت</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.min.css">
    <style>
        .chatbox {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            height: 450px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transform: translateY(20px);
            transition: opacity 0.3s, transform 0.3s;
        }

        .chatbox.show {
            opacity: 1;
            transform: translateY(0);
        }

        .chatbox-header {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: center;
            font-size: 18px;
        }

        .chatbox-body {
            flex-grow: 1;
            padding: 10px;
            overflow-y: auto;
            max-height: 320px;
        }

        .chatbox-footer {
            padding: 10px;
            background-color: #f9f9f9;
            display: flex;
        }

        .chatbox-footer input {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .chatbox-footer button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 10px;
            margin-left: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .chatbox-footer button:hover {
            background-color: #45a049;
        }

        .message {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f1f1f1;
            border-radius: 10px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .message.sent {
            background-color: #d4f8c8;
            margin-left: auto;
            margin-right: 0;
        }

        .message.received {
            background-color: #e5e5e5;
            margin-left: 0;
            margin-right: auto;
        }

        #chatButton:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50">
@if(Session::has('error'))
    <script>
        Swal.fire({
            position: "center",
            icon: "error",
            title: "{{Session::get('error')}}",
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif

@include('layouts.nav')

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        var menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>


@include('component.courses')

<div class="fixed bottom-6 right-6 z-50">
    <button id="chatButton" class="bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 transition">
        <i class="fa fa-comment-alt"></i>
    </button>
</div>



@include('component.chat')

</body>
</html>
