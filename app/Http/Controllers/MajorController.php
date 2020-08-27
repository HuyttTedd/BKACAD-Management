<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Subject;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $majors = Major::all();

        return view('course_major.view_major', compact('majors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course_major.add_major');

    }

    public function viewAddSubjectToMajor()
    {
        $majors = Major::all();
        $subjects = Subject::all();
        return view('subject.add_subject_to_major', compact(['majors', 'subjects']));
    }

    public function addSubjectToMajor(Request $request)
    {
        $major = Major::find($request->course);

        DB::beginTransaction();

        try {
            $major->subjects()->sync($request->subject);

            DB::commit();
            alert()->success('Success!', 'Thêm môn cho ngành thành công');
        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oops..!', 'Đã có lỗi xảy ra. Vui lòng thử lại sau!');
            return redirect()->back();
        }

        return redirect()->route('xem_mon_cua_nganh');

    }

    public function showSubjectOfMajor(){
        $majors = Major::all();

        return view('subject.view_subject_of_major', compact('majors'));
    }

    public function showCourseMajor(Request $request)
	{
		if ($request->ajax()) {
			$majors = Course::find($request->course_id)->majors;

			return response()->json($majors);
		}
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
            'major_id' => ['required', 'unique:majors,id'],
            'major_name' => ['required'],
        ]);

        DB::beginTransaction();

        try {
            $major = Major::create([
                'id' => $request->major_id,
                'major_name' => $request->major_name,
            ]);
            DB::commit();
            alert()->success('Success!', 'Thêm khóa học mới thành công');
        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oop..!', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');
            return redirect()->back();
        }
        return redirect()->route('xem_nganh');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function show(Major $major)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function edit(Major $major)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Major $major)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function destroy(Major $major)
    {
        //
    }
}
