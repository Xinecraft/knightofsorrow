<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;

class PhotosController extends Controller
{
    public function thumbnail($url,$width=500)
    {
        $image = Image::make(public_path().'/uploaded_images/'.$url);

        $image->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $new = new \Intervention\Image\Response($image,null,100);
        return $new->make();
    }
}
