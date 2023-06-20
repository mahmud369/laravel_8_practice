<?php

namespace App\Helpers;

//use Illuminate\Support\Facades\Validator;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UploadHelper
{
    public static function uploadFile($req, $save_dir = 'images', $allowed_types = 'gif,jpg,jpeg,png,bmp,pdf', $max_size = 40960)
    {
        $filePath = '';

        $req->validate([
            'file' => 'mimes:' . $allowed_types . '|max:' . $max_size,
        ]);

        if($req->file('file')) {
            $fileName = $req->file->getClientOriginalName();

            $uploadedFile = $req->file('file');
            $filePath = Storage::disk('public')->put($save_dir, $uploadedFile);
        }
        return [
            'file_name' => $fileName,
            'file_path' => $filePath
        ];
    }

    public static function deleteFile($file_path)
    {
        Storage::disk('public')->delete($file_path);
        return true;
    }
}
