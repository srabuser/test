<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Traits\HasMessages;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use HasMessages;
    public function index()
    {
        $data = Appointment::with('user')->get();
        $messages =  $this->getUserMessages();
        return view('academic.appointments', compact('data','messages'));
    }
}
