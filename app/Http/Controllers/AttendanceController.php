<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceDetail;
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
                        //dd($get_time[1] > $last_att->time_end);

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
                    $att_detail = AttendanceDetail::where('attendance_id', $last_att->id)->get();

                    return view('attendance.update_attendance', compact('att_detail', 'last_att'));
                }
            } else {
                            return view('attendance.view_attendance', compact('arr', 'id'));
            }
        //lấy phân công ra
        }
    }

    public function process_diem_danh(Request $rq) {
        $date = Carbon::now()->toDateString();

        $id =  auth()->user()->id;
        Attendance::create([
            'time_start' => $rq->start,
            'lecturer_id' => $id,
            'date' => $date,
            'subject_id' => $rq->subject_id,
            'time_end' => $rq->end,
        ]
        );

    //đi học :0, muộn: 1; nghỉ: 2; có phép: 3
    $lastAtt = Attendance::where('lecturer_id', $id)->orderBy('id', 'DESC')->first();
    $att_id = $lastAtt->id;
    $class = $rq->class_id;
        foreach ($class as $val) {
                $student = Classes::find($val)->students()->get();
                foreach ($student as $key) {
                $id = $key->id;
                $status = $rq->$id;
                AttendanceDetail::updateOrCreate(
                    ['attendance_id' => $att_id,
                    'student_id' => $id,
                    'class_id' => $val],[
                    'status' => $status,
                    ]
                );
            }
        }

        return redirect()->route('diem_danh');
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
            $classes = $rq->class_id;
            $subject_id = $rq->subject_id;
            $subj = Subject::findOrFail($subject_id);
            $time_total = (int)$subj->total_time;
            $sessions = (int)$subj->total_time / 4;
            $student = ClassStudent::select('student_id')->whereIn('class_id', $classes)->get();
            $arr = array();
            $arr['time_total'] = $time_total;
            foreach ($student as $key) {
                $students = Student::find($key->student_id);
                $arr[$students->id]['sum'] = 0;
                $arr[$students->id]['id'] = $students->id;
                $arr[$students->id]['name'] = $students->fullname;
                $arr[$students->id]['session'] = $sessions;

        }
            foreach ($classes as $class_id) {
                $each_att_id = Attendance::where('subject_id', $subject_id)
                ->join('attendance_details', 'attendances.id', '=', 'attendance_details.attendance_id')
                ->where('attendance_details.class_id', $class_id)->get();
                foreach ($each_att_id as $val) {
                    if($val->status == 0) {
                        $count = 0;
                    } elseif($val->status == 2) {
                        $count = 1;
                    } else {
                        $count = (float)1/3;
                    }
                    $arr[$val->student_id]['sum'] += $count;
                    if($arr[$val->student_id]['sum'] > $time_total * (3/40)) {
                        $arr[$val->student_id]['color'] = '#cccc00';
                    } elseif($arr[$val->student_id]['sum'] > $time_total * (1/8)) {
                        $arr[$val->student_id]['color'] = 'red';
                    } else {
                        $arr[$val->student_id]['color'] = 'green';
                    }
                }
            }

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
