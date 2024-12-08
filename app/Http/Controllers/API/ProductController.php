<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::query()->latest('id')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $product = Product::query()->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Chi tiết sản phẩm'
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $product = Product::query()->findOrFail($id);

            $data = $request->all();

            $validate = Validator($data, [
                'name' => 'nullable|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'quantity' => 'nullable|numeric|min:0',
                'is_active' => 'nullable|boolean',
                'image' => 'nullable|image|max:2048'
            ], [
                'name.max' => 'Tên quá dài',
                'description.string' => 'Mô tả phải là chuỗi',
                'price.numeric' => 'Giá không hợp lệ',
                'price.min' => 'Giá phải lớn hơn 0',
                'quantity.numeric' => 'Số lượng không hợp lệ',
                'quantity.min' => 'Số lượng phải lớn hơn 0',
                'is_active.boolean' => 'Trạng thái không hợp lệ',
                'image.image' => 'Ảnh không hợp lệ',
                'image.max' => 'Kích thước ảnh quá lớn',
            ]);

            if($validate->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi validate',
                    'errors' => $validate->errors()
                ], 422);
            }

            $image = $product->image;
            if ($request->hasFile('image')) {
                if(file_exists($product->image)){
                    Storage::delete($product->image);
                }
    
                $image = $request->file('image')->store('images', 'public');
            }

            $data['image'] = $image;

            $product->update($data);

            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Sửa sản phẩm thành công'
            ], 200);
        } catch(\Throwable $th){
            return response()->json([
                'success' => false,
                'message' => 'Không sửa được sản phẩm',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $product = Product::query()->findOrFail($id);

            if(file_exists($product->image)){
                Storage::delete($product->image);
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Xóa sản phẩm thành công'
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Không xóa được sản phẩm'
            ], 404);
        }
    }
}
