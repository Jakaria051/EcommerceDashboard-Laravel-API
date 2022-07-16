<?php


namespace App\Services\UploadService;

use App\Services\BaseService;
use Illuminate\Http\Request;

class FileUploadService extends BaseService
{
    public function uploadProductImage(Request $request)
    {
        if ($request->has('file_path')) {
            $file = $request->file('file_path');
            return $file;
            $destinationPath = "uploads/products_photos";
            $fileName = rand(100000, 999999).time();
            $file->move($destinationPath, $fileName);
            return $destinationPath.'/'.$fileName;
        }
       return gettype($request->file_path);
       $itemPath = str_replace(':\\fakepath\\',"",$request->file_path);
       $removeFirstCharacter = ltrim($itemPath, $itemPath[0]); //item name 

    

        return $removeFirstCharacter;
    }

    // public function updateProductImage($request, $updateProductName)
    // {
    //     if ($request->hasFile('imagePath')) {
    //         if (file_exists($updateProductName->imagePath)) {
    //             unlink($updateProductName->imagePath);
    //         }
    //         $file = $request->file('imagePath');
    //         $destinationPath = "uploads/products_photos";
    //         $fileName = rand(100000, 999999).'.jpg';
    //         $file->move($destinationPath, $fileName);
    //         return $destinationPath.'/'.$fileName;
    //     }
    // }

}
