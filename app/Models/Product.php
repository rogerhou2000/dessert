<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="product";
    protected $primaryKey="id";
    
    protected $fillable = [
        "id",
        "itemName",
        "typeId",
        "img",
        "price",
        "status",
        "ingredient",
        "description",
        "createTime"
    ];
    // public function checkProduct($itemName)
    // {
    //     return self::where("itemName", $itemName)->first();
    // }
    // public function onlineProduct()
    // {
    //     return self::where("status", 1);
    // }
    public function productCount(){
        $result = DB::table('product')
        ->select(DB::raw("
            COUNT(*) AS product
        "))->first()->product;
        return $result;

    }

    // 關聯 (如果有類型表，可以加上關聯)
}
