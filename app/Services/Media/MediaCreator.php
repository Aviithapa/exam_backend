<?php

namespace App\Services\Media;

use App\Models\Question;
use App\Repositories\Media\MediaRepository;
use App\Repositories\Questions\QuestionsRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class MediaCreator
{
    /**
     * @var MediaRepository
     */
    protected $mediaRepository;

    /**
     * StudentGetter constructor.
     * @param MediaRepository $mediaRepository
     */
    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }


    public function store($request)
    {
        $data = $request->all();
        $imageStore = new ImageStore();
        $imageName = $imageStore->storeImage($request);
        $data['image_name'] = $imageName;
        return $this->mediaRepository->create($data);
    }
}
