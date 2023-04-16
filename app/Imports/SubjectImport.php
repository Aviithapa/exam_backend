<?php

namespace App\Imports;

use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToModel, WithHeadingRow
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Subject([
            'name' => $row['name'],
            'display_name' => $row['display_name'],
            'created_by' => Auth::user()->id
        ]);
    }
}
