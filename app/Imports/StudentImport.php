<?php

namespace App\Imports;

use App\Models\Student;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new Student([
            'fullname' => $row['fullname'],
            'gender' => ($row['gender'] == 'Male') ? 1 : 0,
            'dob' => date_format(new DateTime($row['dob']), 'Y-m-d'),
            'phone' => $row['phone'],
            'email' => $row['email'],
            'password' => bcrypt('12345678'),
            'status' => 0
        ]);
    }

    public function headingRow() : int
    {
        return 1;
    }

}
