<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

use Session;

class StoreImageFileController extends Controller
{
    public function createFile(Request $request){
       //generate random file name
        // $randFileName = public_path().'/bills/'.uniqid();
        //save image file on root website folder
        // file_put_contents($randFileName, $request->input('base64ImageContent'));
        //return file name back to client
        // dd($request->input('base64ImageContent'));
        $randFileName = $this->createImageFromBase64($request->input('base64ImageContent'));
        return response($randFileName)
                        ->header('Content-Type', 'text/plain');

    }

    public function createImageFromBase64($image){
      // dd($image);
        $filename = 'image_'.time().'.png'; //generating unique file name;
        $path = public_path('images/kbills')."/". $filename;

        Image::make(file_get_contents($image))->save($path);
         return $filename;
     }

}
