<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>حساب المعدل</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />

    <style>
        body {
            background-color: #4c8cbf;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }

        /* Your existing styles unchanged ... */

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
            background-color: #4caf50;
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
            color: #222;
        }

        .chatbox-footer button {
            padding: 8px 12px;
            background-color: #4caf50;
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
            color: #222;
        }

        .message.sent {
            background-color: #a7d7a7;
            color: #222;
            margin-left: auto;
            margin-right: 0;
        }

        .message.received {
            background-color: #cccccc;
            color: #222;
            margin-left: 0;
            margin-right: auto;
        }

        #chatButton:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
        }

        .container {
            max-width: 700px;
            margin: 140px auto 50px auto;
            direction: rtl;
        }

        .box {
            border: 1px solid white;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.9);
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
            color: #222;
        }

        .box h3 {
            text-align: center;
            margin-bottom: 12px;
            font-weight: 700;
            font-size: 18px;
            color: #222;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 14px;
            color: #222;
        }

        input[type='number'],
        input[type='text'],
        select {
            width: 100%;
            border-radius: 6px;
            border: none;
            padding: 8px 10px;
            font-size: 15px;
            color: #222;
            background: white;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[disabled],
        select[disabled] {
            background-color: #a3b5cd;
            cursor: not-allowed;
            color: #666;
        }

        .radio-group {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }

        .radio-group label {
            font-weight: normal;
            color: #222;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        input[type='radio'] {
            accent-color: #2980b9;
            cursor: pointer;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            background: #4c6e9e;
            border-radius: 8px;
            overflow: hidden;
            color: white;
            margin-bottom: 15px;
        }

        th,
        td {
            padding: 8px 10px;
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
        }

        th {
            font-weight: 600;
            background-color: #3d5f89;
        }

        input[type='checkbox'] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .summary-boxes {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            color: white;
        }

        .summary-box {
            border: 1px solid white;
            border-radius: 4px;
            padding: 15px 20px;
            width: 48%;
            background: rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .summary-box p {
            margin: 8px 0;
            font-size: 16px;
        }

        .summary-box p span.label {
            float: right;
            font-weight: 600;
        }

        .summary-box p span.value {
            float: left;
            font-weight: 700;
        }

        /* New clickable card style replacing button */
        #calculateCard {
            background-color: #28a745;
            color: white;
            max-width: 220px;
            margin: 30px auto;
            padding: 18px 0;
            border-radius: 14px;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(40, 167, 69, 0.7);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
            border: 2px solid #1e7e34;
        }

        #calculateCard:hover,
        #calculateCard:focus {
            background-color: #218838;
            box-shadow: 0 9px 18px rgba(33, 136, 56, 0.9);
            outline: none;
        }

        /* Display cumulative GPA clearly below */
        #resultsDisplay {
            max-width: 320px;
            margin: 20px auto 60px auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 20px;
            color: #222;
            font-size: 18px;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 3px 6px rgba(0,0,0,0.15);
            user-select: none;
        }

        #resultsDisplay p {
            margin: 12px 0;
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

    <!-- START: Grade Calculator Content -->
    <section id="calcGrade" class="container" role="main" aria-label="حاسبة المعدل">

        <!-- New Inputs for previous hours & GPA -->
        <div class="box" role="region" aria-labelledby="prev-info-title">
            <h3 id="prev-info-title">الساعات / المعدل التراكمي</h3>
            <label for="prev_hours_input">عدد الساعات السابقة</label>
            <input type="number" id="prev_hours_input" name="prev_hours_input" value="0" min="0" aria-describedby="prev_hours_help" />

            <label for="prev_gpa_input">المعدل التراكمي </label>
            <input type="number" id="prev_gpa_input" name="prev_gpa_input" value="0" step="0.01" min="0" max="5" aria-describedby="prev_gpa_help" />
        </div>

        <!-- Subjects Table -->
        <table role="table" aria-label="جدول المواد والساعات والتقديرات">
            <thead>
                <tr>
                    <th scope="col">اختر</th>
                    <th scope="col">اسم المادة</th>
                    <th scope="col">الساعات</th>
                    <th scope="col">التقدير</th>
                </tr>
            </thead>
            <tbody id="subjectsTableBody">
                <tr>
                    <td><input type="checkbox" class="include-course" checked /></td>
                    <td><input type="text" placeholder="اسم المادة" /></td>
                    <td><input type="number" min="1" max="6" value="3" /></td>
                    <td>
                        <select>
                            <option value="5">+A</option>
                            <option value="4.75">A</option>
                            <option value="4.25">B+</option>
                            <option value="4">B</option>
                            <option value="3.5">C+</option>
                            <option value="3">C</option>
                            <option value="2">D</option>
                            <option value="0">F</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="include-course" checked /></td>
                    <td><input type="text" placeholder="اسم المادة" /></td>
                    <td><input type="number" min="1" max="6" value="3" /></td>
                    <td>
                        <select>
                            <option value="5">+A</option>
                            <option value="4.75">A</option>
                            <option value="4.25">B+</option>
                            <option value="4">B</option>
                            <option value="3.5">C+</option>
                            <option value="3">C</option>
                            <option value="2">D</option>
                            <option value="0">F</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="include-course" checked /></td>
                    <td><input type="text" placeholder="اسم المادة" /></td>
                    <td><input type="number" min="1" max="6" value="3" /></td>
                    <td>
                        <select>
                            <option value="5">+A</option>
                            <option value="4.75">A</option>
                            <option value="4.25">B+</option>
                            <option value="4">B</option>
                            <option value="3.5">C+</option>
                            <option value="3">C</option>
                            <option value="2">D</option>
                            <option value="0">F</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="include-course" checked /></td>
                    <td><input type="text" placeholder="اسم المادة" /></td>
                    <td><input type="number" min="1" max="6" value="3" /></td>
                    <td>
                        <select>
                            <option value="5">+A</option>
                            <option value="4.75">A</option>
                            <option value="4.25">B+</option>
                            <option value="4">B</option>
                            <option value="3.5">C+</option>
                            <option value="3">C</option>
                            <option value="2">D</option>
                            <option value="0">F</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="include-course" checked /></td>
                    <td><input type="text" placeholder="اسم المادة" /></td>
                    <td><input type="number" min="1" max="6" value="3" /></td>
                    <td>
                        <select>
                            <option value="5">+A</option>
                            <option value="4.75">A</option>
                            <option value="4.25">B+</option>
                            <option value="4">B</option>
                            <option value="3.5">C+</option>
                            <option value="3">C</option>
                            <option value="2">D</option>
                            <option value="0">F</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Calculate card instead of button -->
        <div id="calculateCard" role="button" tabindex="0" aria-label="احسب المعدل">احسب المعدل</div>

        <!-- Clear display area for results -->
        <div id="resultsDisplay" aria-live="polite" aria-atomic="true" role="region" aria-label="نتائج حساب المعدل">
            <p>المعدل الفصلي: <span id="displaySemesterGPA">0.00</span></p>
            <p>المعدل التراكمي الجديد: <span id="displayCumulativeGPA">0.00</span></p>
        </div>

    </section>
    <!-- END: Grade Calculator Content -->

    <div class="fixed bottom-6 right-6 z-50">
        <button
            id="chatButton"
            class="bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 transition"
            aria-label="فتح دردشة الدعم"
        >
            <i class="fa fa-comment-alt"></i>
        </button>
    </div>

    @include('component.chat')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const calculateCard = document.getElementById('calculateCard');

            function calculateGPA() {
                const prevHours = Number(document.getElementById('prev_hours_input').value) || 0;
                const prevGPA = Number(document.getElementById('prev_gpa_input').value) || 0;

                const rows = document.querySelectorAll('#subjectsTableBody tr');
                let semesterPoints = 0;
                let semesterHours = 0;

                rows.forEach(row => {
                    const isChecked = row.querySelector('.include-course').checked;
                    if (!isChecked) return;

                    const hours = Number(row.querySelector('input[type="number"]').value) || 0;
                    const grade = Number(row.querySelector('select').value) || 0;

                    semesterPoints += grade * hours;
                    semesterHours += hours;
                });

                const cumulativePoints = prevHours * prevGPA;
                const totalPoints = cumulativePoints + semesterPoints;
                const totalHours = prevHours + semesterHours;

                const cumulativeGPA = totalHours > 0 ? (totalPoints / totalHours) : 0;
                const semesterGPA = semesterHours > 0 ? (semesterPoints / semesterHours) : 0;

                document.getElementById('displayCumulativeGPA').textContent = cumulativeGPA.toFixed(2);
                document.getElementById('displaySemesterGPA').textContent = semesterGPA.toFixed(2);
            }

            calculateCard.addEventListener('click', calculateGPA);
            calculateCard.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    calculateGPA();
                }
            });
        });
    </script>

</body>
</html>
