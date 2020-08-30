<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Models\Classes;
use App\Models\Major;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $courses = Course::all();
        return view('student.import_student', compact('courses'));
    }


    public function index()
    {
        //
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
    public function storeImport(Request $rq)
    {
        $this->validate($rq, [
            'file'  => 'required|mimes:xls,xlsx',
            'course' => 'required',
            'major' => 'required',
            'total' => 'required',
            'each' => 'required',
        ]);

        $course_id = $rq->course;
        $major_id = $rq->major;
        $total = $rq->total;
        $each = $rq->each;
        $course_name = Course::findOrFail($course_id)->name;
        $data = [
            'course_id' => $course_id,
            'major_id' => $major_id,
            'total' => $total,
            'each' => $each,
            'course_name' => $course_name,
        ];

        Excel::import(new StudentImport($data),request()->file('file'));

        return redirect()->route('dashboard');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
