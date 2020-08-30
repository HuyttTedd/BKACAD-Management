<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();

        return view('course_major.view_course', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course_major.add_course');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'course' => ['required', 'unique:courses,course_name'],
        ]);

        DB::beginTransaction();

        try {
            $course = Course::create([
                'course_name' => $request->course,
            ]);
            DB::commit();
            alert()->success('Success!', 'Thêm khóa học mới thành công');
        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oop..!', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');
            return redirect()->back();
        }
        return redirect()->route('xem_khoa');

    }

    public function viewAddMajorToCourse()
    {
        $courses = Course::all();

        $majors = Major::all();

        return view('course_major.add_major_to_course', compact(['courses', 'majors']));
    }

    public function addMajorToCourse(Request $request)
    {
        $course = Course::find($request->course);

        $majors = $request->major;
        // dd($course);
        //dd($majors);
        DB::beginTransaction();
        try {
            $course->majors()->sync($majors);
            DB::commit();
            alert()->success('Success');
        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oop..!');
            return redirect()->back();
        }

        return redirect()->route('khoa_chi_tiet');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function showDetails()
    {
        $courses = Course::all();

        return view('course_major.view_course_detail', compact('courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
