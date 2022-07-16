<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\UploadService\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    private $file;

    public function __construct(FileUploadService $fileService)
    {
        $this->file = $fileService;
    }


    public function addProduct(Request $request) 
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'required|string',
                'file_path' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(),'status_code' => 401]);
        }

        $product = new Product();
        $product->fill($request->all());
        $product->file_path = $request->file_path->store('products');

        $product->save();
       
        if ($product) {
            return response()->json(['success' => $product,'status_code' => 201]);
        }
        return response()->json(['error' => "Something wrong!",'status_code' => 400]);
    }

    public function listOfProduct()
    {
        return Product::all();
    }
}
