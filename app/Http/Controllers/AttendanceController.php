<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassStudent;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(auth()->user()->hasRole('lecturer')) {
        //     $class = App\Models\Assignment::where
        // }
        // return view('attendance.view_attendance');
    }

    public function diem_danh()
    {
        //dd(auth()->user()->hasRole('lecturer'));
        if(auth()->user()->hasRole('lecturer')) {
        //select last attendance
            $id = auth()->user()->id;
            $last_att = Attendance::where('lecturer_id', $id)->orderBy('id', 'DESC')->first();
            $date_time = Carbon::now()->toDateTimeString();
            $get_time = explode(" ", $date_time);
            //lay phan cong
            $phan_cong = Assignment::where('lecturer_id', $id)->get();
                                    $arr = array();
                                    $arr_id = array();
                                    foreach ($phan_cong as $key) {
                                        if(!in_array($key->subject_id, $arr_id)){
                                            $subject = Subject::find($key->subject_id);
                                            array_push($arr, [$subject->id, $subject->subject_name]);
                                            array_push($arr_id, $key->subject_id);
                                        }
                                    }

            if(!empty($last_att)) {
                    if($get_time[0] > $last_att->date || $get_time[1] > $last_att->time_end) {
                    //dd($get_time);
                            return view('attendance.view_attendance', compact('arr', 'id'));
                } else {
                            return view('attendance.update_attendance');
                }
            } else {
                            return view('attendance.view_attendance', compact('arr', 'id'));
            }


        //lấy phân công ra

        }
    }

    public function process_diem_danh(Request $rq) {
        $date = Carbon::now()->toDateString();
        Attendance::updateOrCreate([
            'time_start' => $rq->start,
            'lecturer_id' => auth()->user()->id,
            'class_id' => $rq->class_id,
            'date' => $date,
            'subject_id' => $rq->subject_id,
            ],[
            'time_end' => $rq->end,
        ]
        );
    }

    public function ajax_diem_danh(Request $rq) {
        if($rq->ajax()) {
            if(isset($rq->subject_id)) {
            $class = Assignment::where('lecturer_id', $rq->id_user)->where('subject_id', $rq->subject_id)->get();
            $arr = array();
            foreach ($class as $key) {
                    $classes = Classes::find($key->class_id);
                    array_push($arr, [$classes->id, $classes->class_name]);
            }
                return response()->json($arr);
            }
    }
}



    public function ajax_diem_danh2(Request $rq) {
        if($rq->ajax()) {

            $student = ClassStudent::select('student_id')->whereIn('class_id', $rq->class_id)->get();
            $arr = array();
            foreach ($student as $key) {
                    $students = Student::find($key->student_id);
                    array_push($arr, $students);
            }
// $arr2=[];
// $a = 0;
//             foreach ($arr as $key => $value) {
//                 # code...
//                 $a++;
//                 array_push($arr2, $a);

//             }

                return response()->json($arr);

    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
