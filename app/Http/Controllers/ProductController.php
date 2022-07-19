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

    public function productDetail($id)
    {
        $data = Product::where('id',$id)->first();
        if ($data) {
            return response()->json(['result' => $data, 'status_code' => 200]);
        }
        return response()->json(['result' => 'Operation failed!','status_code' => 404]);
    }
    
    public function updateProduct($id,Request $request)
    {
        $product = Product::find($id);
        $product->product_name = $request->input("product_name");
        $product->description = $request->input("description");
        $product->price = $request->input("price");
        if ($request->file('file_path')) {
            $product->file_path = $request->file_path->store('products');
            
        }
        $product->save();
        if($product) {
            return response()->json(['result' => $product, 'status_code' => 201]);
        }
        return response()->json(['result' => 'Operation failed!','status_code' => 404]);
    }

    public function deleteProduct($id)
    {
        $delete = Product::where('id',$id)->delete();
        if ($delete) {
            return response()->json(['result' => 'Product has been deleted','status_code' => 200]);
        }
        return response()->json(['result' => 'Operation failed!','status_code' => 404]);
    }
}
