<?php

namespace App\Services\User;

use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\Subject\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class UserGetter
{
    /**
     * @var UserRepository
     */
    protected $userRepository, $subjectRepository, $studentRepository;

    /**
     * ApartmentGetter constructor.
     * @param ApartmentRepository $apartmentRepository
     */
    public function __construct(UserRepository $userRepository, SubjectRepository $subjectRepository, StudentRepository $studentRepository)
    {
        $this->userRepository = $userRepository;
        $this->subjectRepository = $subjectRepository;
        $this->studentRepository = $studentRepository;
    }

    /**
     * Get paginated apartment list
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getPaginatedList(): LengthAwarePaginator
    {
        return $this->userRepository->getWithPagination();
    }

    /**
     * Get a single apartment
     * @param $id
     * @return Object|null
     */
    public function show($id)
    {
        $userData = $this->userRepository->findById($id);
        $subjects = $this->subjectRepository->getAll()->where('created_by', $id);
        $subjectData = [];
        foreach ($subjects as $subject) {
            $students = $this->studentRepository->getAll()->where('subject_id', $subject->id);
            $subjectData[] = [
                'subject' => $subject,
                'student_count' => $students->count(),
            ];
        }
        $subjectCount = count($subjectData);
        $user = Auth::user()->id;

        $responseData = [
            'user_data' => $userData,
            'subject_data' => $subjectData,
            'subject_count' => $subjectCount,
            'user' => $user
        ];

        return $responseData;
    }
}
