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
    public function storeImport(Request $request)
    {
        // Excel::import(new StudentImport, $request->file('file'));
        $studentPerClass = 40;
        $studentNoClass = DB::select('select count(id) as total_student from students where id not in(select student_id from class_students)');

        $course = $request->course;
        $major = $request->major;

        $totalClass = floor($studentNoClass[0]->total_student/$studentPerClass);

        // $major_name = Major::find($major);
        // $course_name = Course::find($course);
        // for($i = 1; $i <= $totalClass; $i++){
        //     Classes::create([
        //         'class_name' => $major_name->id.'0'.$i.$course_name->course_name,
        //     ]);
        // }
        dd(Classes::all());

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
