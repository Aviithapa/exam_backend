<?php

namespace App\Repositories\Student;

use App\Repositories\Repository;

interface StudentRepository  extends  Repository
{
    public function checkBySnDob($sn, $dob);
}
