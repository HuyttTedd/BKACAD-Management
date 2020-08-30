<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Classes;
use App\Models\ClassStudent;

use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;

class StudentImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function headingRow() : int
    {
        return 1;
    }

    public function collection(Collection $rows)
    {
        $i = 0;
        $arr = array();
        $arr = $this->data;
        foreach ($rows as $row)
        {
            Student::create([
                        'fullname' => $row["ten_sinh_vien"],
                        'gender' => $row["gioi_tinh"] == 'nam' ? 1 : 0,
                        //'dob' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['ngay_sinh'])->format('Y-m-d'),
                        'dob' => $row['ngay_sinh'],
                        'phone' => $row["so_dien_thoai"],
                        'email' => $row["email"],
                        'password' => Hash::make('123456'),
                        //'status' => '0',
            ]);

            $student = Student::all()->last();

            if($i % (int)$arr['each'] == 0) {
                $count = Classes::all()->count();
                Classes::create([
                'class_name' => 'BKC'.($count + 10).$arr['course_name'],
                'course_id' => $arr['course_id'],
                'major_id' => $arr["major_id"],
            ]);
            }

            $lastClass = Classes::all()->last();
            ClassStudent::create([
                'student_id' => $student->id,
                'class_id' => $lastClass->id,
            ]);

            $i++;
        }
}
}
