<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ChatLog;
use App\Models\Course;
use App\Traits\RuleMatchingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatLogController extends Controller
{

    use RuleMatchingTrait;


    public function store(Request $request)
    {
        $question = $request->question;
        $responses = collect();



        $appointments = Appointment::where('available', '1')
            ->when(!str_contains($question, 'حجز موعد'), function ($query) use ($question) {
                $query->where(function ($q) use ($question) {
                    $q->where('day', 'like', "%$question%")
                        ->orWhere('time', 'like', "%$question%");
                });
            })
            ->get();


         $responses = $responses->merge(
                $appointments->map(function ($appointment) {
                    return [
                        'type' => 'appointment',
                        'day' => $appointment->day,
                        'time' => $appointment->time,
                        'available' => $appointment->available,
                        'id' => $appointment->id
                    ];
                })
            );



        $courses = Course::where('course_code', 'like', "%$question%")
            ->orWhere('name', 'like', "%$question%")
            ->orWhere('level', 'like', "%$question%")
            ->get();

        $responses = $responses->merge(
            $courses->map(function ($course) {
                return [
                    'type' => 'course',
                    'name' => $course->name,
                    'course_code' => $course->course_code,
                    'code' => $course->code,
                    'units' => $course->units_number,
                    'requirement' => $course->require
                ];
            })
        );


        $userEmbedding = $this->generateEmbedding($question);
        $bestRule = $this->findBestMatchingRule($userEmbedding);

        if ($bestRule) {
            $responses = $responses->push([
                'type' => 'rule',
                'answer' => $bestRule->answer,
                'category' => $bestRule->category,
            ]);
        }

        if ($responses->isEmpty()) {
            $responses->push([
                'type' => 'default',
                'message' => 'عذرًا، لم أتمكن من العثور على نتيجة لسؤالك.'
            ]);
            $responses->push([
                'type' => 'default',
                'message' => 'اعد السؤال بصيغة اخرى, أو اكتب "حجز موعد" لحجز موعد مع المرشد الأكاديمي'
            ]);
        }


        ChatLog::create([
            'message' => $question,
            'answer' => $responses,
            'user_id' => Auth::id(),
        ]);

        return response()->json($responses);
    }

    public function bookAppointment(Appointment $appointment)
    {
        if ($appointment->available == 0) {
            return response()->json(['message' => 'الموعد محجوز مسبقاً.']);
        }

        $appointment->update(['available' => '0']);
        $appointment->user()->syncWithoutDetaching([Auth::id()]);

        return response()->json(['message' => 'تم حجز الموعد بنجاح.']);
    }


}
