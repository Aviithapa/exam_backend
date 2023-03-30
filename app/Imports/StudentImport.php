<?php

namespace App\Imports;

use App\Models\Students;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel
{

    public function model(array $row)
    {
        $student = new Students([
            'name' => $row[0],
            'email' => $row[1],
            'symbol_number' => $row[2],
            'photo' => $row[3],
            'phone_number' => $row[4],
            'date_of_birth' => $row[5],
        ]);

        return $student;
    }
}
