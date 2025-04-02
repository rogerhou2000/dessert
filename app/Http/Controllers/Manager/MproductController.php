<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Upload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MproductController extends Controller
{
    private function respond($state, $message, $data = null)
    {
        return response()->json(["state" => $state, "message" => $message, "data" => $data], 200);
    }
     public function index()
    {
        return view("manager.product");
    }//// //
    //
    public function add(Request $req)
    {
        if (!isset($req['description'], $req['image'], $req['ingredients'], $req['itemName'], $req['price'], $req['state'], $req['typeId'])) {
            return $this->respond(false, "欄位缺失！");
        }


        $product = new Product();
        $fileName = "";
        if ($req->hasFile('image')) {
            $photo = $req['image'];
            $fileName = Upload::uploadPhoto($photo, "images/product");
            $product->img = $fileName;
        }try {
        $product->itemName = $req['itemName'];
        $product->typeId = $req['typeId'];
        $product->price = $req['price'];
        $product->status =  filter_var($req->state, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $product->ingredient = $req['ingredients'] ;
        $product->description = $req['description'] ;

        
            $product->save();
            return $this->respond(true, "新增成功");
        } catch (Exception $e) {
            if (!empty($fileName) && file_exists("images/product/" . $fileName)) {
                unlink("images/product/" . $fileName);
            }
            return $this->respond(false, "新增失敗：" . $e->getMessage());
        }
    }
    public function update(Request $req)
    {

        if (!isset($req['id'], $req['description'], $req['img'], $req['ingredients'], $req['price'], $req['state'], $req['typeId'])) {
            return $this->respond(false, "欄位缺失！");
        }

        $id = $req['id'];
        $product = Product::find($id);
        if (!$product) {
            return $this->respond(false, "找不到此商品！");
        }
        DB::beginTransaction();

        try {
            $oldImg = $product->img;

            // 檢查是否有上傳新圖片
            if ($req->hasFile('img')) {
                $fileName = Upload::uploadPhoto($req->file('img'), "images/product");
                $product->img = $fileName;
            }
            $product->typeId = $req['typeId'];
            $product->price = $req->price;
            $product->status = filter_var($req->state, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
            $product->ingredient = $req->ingredients;
            $product->description = $req->description;

            $product->save();

            DB::commit();

            // 如果有舊圖片且已成功存檔，刪除舊圖片
            if (!empty($oldImg) && isset($fileName)) {
                @unlink("images/product/" . $oldImg);
            }

            return $this->respond(true, "更新成功！");
        } catch (\Exception $e) {
            DB::rollBack();

            // 刪除新上傳的圖片（如果存在）
            if (isset($fileName)) {
                @unlink("images/product/" . $fileName);
            }

            return $this->respond(false, "更新失敗：" . $e->getMessage());
        }
    }public function delete(Request $req)
    {
        try {
            $product = Product::find($req->id);
    
            if ($product) {
               $fileName=$product->img ; 
                if (isset($fileName)) {
                    @unlink("images/product/" . $fileName);
                }
                $product->delete();
                return $this->respond(true, "產品已成功刪除！");
            } else {
                return $this->respond(false, "找不到該產品，無法刪除。");
            }
        } catch (Exception $e) {
            return $this->respond(false, "發生錯誤：" . $e->getMessage());
        }
    }
    
}
