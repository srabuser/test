<?php

namespace App\Http\Controllers;

use App\Models\ChatLog;
use App\Models\User;
use App\Traits\HasMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use HasMessages;
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $messages =  $this->getUserMessages();

        return view('index', compact('messages'));
    }

    public function help()
    {
       $messages =  $this->getUserMessages();

        return view('help', compact('messages'));
    }
    public function trtebh()
    {
        $messages =  $this->getUserMessages();

        return view('trtebh', compact('messages'));
    }
    public function requirements()
    {
        $messages =  $this->getUserMessages();

        return view('requirements', compact('messages'));
    }
    public function calcGrade()
{
    $messages = $this->getUserMessages();
    return view('calcGrade', compact('messages'));
}

public function calculateGrade(Request $request)
{
    $courses = $request->input('courses');

    // Validate input
    if (!$courses || !is_array($courses) || count($courses) === 0) {
        return redirect()->back()->withErrors(['courses' => 'يرجى إدخال معلومات المواد']);
    }

    $totalUnits = 0;
    $totalPoints = 0;

    foreach ($courses as $course) {
        $units = isset($course['units']) ? (float) $course['units'] : 0;
        $grade = isset($course['grade']) ? strtoupper(trim($course['grade'])) : '';

        // Validate units and grade
        if ($units <= 0) {
            return redirect()->back()->withErrors(['courses' => 'الوحدات يجب أن تكون رقم موجب']);
        }

        $point = $this->gradeToPoint($grade);

        if ($point === null) {
            return redirect()->back()->withErrors(['courses' => 'درجة غير صحيحة: ' . $grade]);
        }

        $totalUnits += $units;
        $totalPoints += $units * $point;
    }

    if ($totalUnits == 0) {
        return redirect()->back()->withErrors(['courses' => 'الوحدات الإجمالية لا يمكن أن تكون صفر']);
    }

    $gpa = $totalPoints / $totalUnits;

    $messages = $this->getUserMessages();

    return view('calcGrade', compact('gpa', 'messages', 'courses'));
}

private function gradeToPoint($grade)
{
    $mapping = [
        'A+' => 4.0,
        'A'  => 4.0,
        'A-' => 3.7,
        'B+' => 3.3,
        'B'  => 3.0,
        'B-' => 2.7,
        'C+' => 2.3,
        'C'  => 2.0,
        'C-' => 1.7,
        'D+' => 1.3,
        'D'  => 1.0,
        'F'  => 0.0,
    ];

    return $mapping[$grade] ?? null;
}

}
