<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Major;
use App\User;
use Illuminate\Support\Facades\DB;


class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function phan_cong()
    {
        //dd(auth()->user()->id);
        $khoa_hoc = Course::orderBy('id', 'DESC')->get();
        $user = User::role('lecturer')->get();
        //dd($user);

        return view('assignment.assignment', compact('khoa_hoc', 'user'));
    }

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


    public function process_phan_cong(Request $rq) {
        $data = request()->validate([
            'course_id' => 'required',
            'major_id' =>'required',
            'lecturer_id' =>'required',
            'subject_id' =>'required',
            'class' =>'required',
        ]);
        $arr = $rq->class;
        //dd($arr);
        //DB::beginTransaction();

        foreach ($arr as $val) {
            Assignment::updateOrCreate([
                'class_id' => $val,
                'subject_id' => $rq->subject_id],[
                'lecturer_id' =>$rq->lecturer_id,
            ]);
        }

        //return redirect()->route('khoa_chi_tiet');

    }


    // public function showCourseMajor(Request $request)
	// {
	// 	if ($request->ajax()) {
	// 		$majors = Course::find($request->course_id)->majors;

	// 		return response()->json($majors);
	// 	}
	// }
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
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
