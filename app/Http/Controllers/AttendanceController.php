<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\ClassStudent;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

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
            //dd($arr);
            if(!empty($last_att)) {
                    if($get_time[0] > $last_att->date || $get_time[1] > $last_att->time_end) {
                    //dd($get_time);
                            return view('attendance.view_attendance', compact('arr', 'id'));
                } else {

                    $att_detail = AttendanceDetail::where('attendance_id', $last_att->id)->get();
                    $class_list = AttendanceDetail::where('attendance_id', $last_att->id)->get()->unique('class_id');
                    //dd($class_list);
                        $arr_class = [];
                    foreach ($class_list as $key => $value) {
                        $classes = Classes::find($value->class_id);
                        $arr_class[$classes->id] = $classes->class_name;

                    }

                    $arr_update = array();
                    $time_total = Subject::find($last_att->subject_id)->total_time;
                    foreach ($att_detail as $val) {
                        $count_update = 0;
                        $student = Student::find($val->student_id);
                        if($val->status == 0) {
                            $count_update = 0;
                        } elseif($val->status == 2) {
                            $count_update = 1;
                        } else {
                            $count_update = (float)1/3;
                        }
                        if(!isset($arr_update[$student->id]['sum'])) {
                            $arr_update[$student->id]['sum'] = 0;
                        }

                        $arr_update[$student->id]['sum'] += $count_update;
                        $arr_update[$student->id]['id'] = $student->id;
                        $arr_update[$student->id]['name'] = $student->fullname;
                        $arr_update[$student->id]['last_status'] = $val->status;
                        if($arr_update[$student->id]['sum'] > $time_total * (3/40)) {
                            $arr_update[$student->id]['color'] = '#cccc00';
                        } else {
                            $arr_update[$student->id]['color'] = 'green';
                        }
                        if($arr_update[$student->id]['sum'] > $time_total * (1/8)) {
                            $arr_update[$student->id]['color'] = 'red';
                        }
                    }
                    Session::put('class_id', $arr_class);
                    $sub = Subject::find($last_att->subject_id);
                    //dd($arr_update);
                        return view('attendance.update_attendance', compact('att_detail', 'last_att', 'sub', 'arr_update', 'arr_class'));
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

    public function process_update_diem_danh(Request $rq) {
        $id =  auth()->user()->id;
        $lastAtt = Attendance::where('lecturer_id', $id)->orderBy('id', 'DESC')->first();
        $att_id = $lastAtt->id;
        $class = Session::get('class_id');
        //dd($class);
        foreach ($class as $val => $item) {
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

        return redirect('/');
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
            $sessions = (int)$time_total / 4;
            $student = ClassStudent::select('student_id')->whereIn('class_id', $classes)->get();
            $arr = array();
            $arr['time_total'] = $time_total;
            $arr['session'] = $sessions;
            foreach ($student as $key) {
                $students = Student::find($key->student_id);
                $arr[$students->id]['sum'] = 0;
                $arr[$students->id]['id'] = $students->id;
                $arr[$students->id]['name'] = $students->fullname;
                $arr[$students->id]['session'] = $sessions;
                $arr[$students->id]['color'] = 'green';
        }
            foreach ($classes as $class_id) {
                $each_att_id = Attendance::where('subject_id', $subject_id)
                ->join('attendance_details', 'attendances.id', '=', 'attendance_details.attendance_id')
                ->where('attendance_details.class_id', $class_id)->get();
                if(!empty($each_att_id)) {
                    foreach ($each_att_id as $val) {
                        if($val->status == 0) {
                            $count = 0;
                        } elseif($val->status == 2) {
                            $count = 1;
                        } else {
                            $count = (float)1/3;
                        }
                        $arr[$val->student_id]['sum'] += $count;
                        //$arr[$val->student_id]['color'] = 'red';
                        if($arr[$val->student_id]['sum'] > $time_total * (3/40)) {
                            $arr[$val->student_id]['color'] = '#cccc00';
                        } else {
                            $arr[$val->student_id]['color'] = 'green';
                        }
                        if($arr[$val->student_id]['sum'] > $time_total * (1/8)) {
                            $arr[$val->student_id]['color'] = 'red';
                        }
                    }
                }
            }

        return response()->json($arr);
    }
}

    public function lich_su_diem_danh() {
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
        return view('attendance.history_attendance', compact('arr'));
    }


    public function thong_ke_diem_danh() {
        $khoa_hoc = Course::orderBy('id', 'DESC')->get();

        return view('attendance.admin_attendance', compact('khoa_hoc'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ajax_phan_cong(Request $rq) {
        if($rq->ajax()) {
            if(isset($rq->course_id)) {
            $major = Course::find($rq->course_id)->majors;
                return response()->json($major);
            }
            if(isset($rq->major_id)) {
            $classes = Major::findOrFail($rq->major_id)->classes()->get();
                return response()->json($classes);
            }
        }
    }

    public function ajax_phan_cong1(Request $rq) {
        if($rq->ajax()) {
            if(isset($rq->major_id)) {
            $subject = Major::findOrFail($rq->major_id)->subjects()->get();
                return response()->json($subject);
            }
        }
    }

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
