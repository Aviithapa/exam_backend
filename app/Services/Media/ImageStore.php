<?php

namespace App\Services\Media;


use Intervention\Image\Facades\Image;

class ImageStore
{

    public function storeImage($request)
    {

        $data = $request->all();
        $image = $request->file('photo');
        $filename = time() . '-' . $data['symbol_number'] . '.png';
        $directory = public_path($data['origanization'] . '/' . $data['symbol_number']);
        $location = $directory . '/' . $filename;

        // Check if the directory already exists, and create it if it doesn't
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        // Save the uploaded image to the specified location
        Image::make($image)->save($location);

        return $filename;
    }
}
