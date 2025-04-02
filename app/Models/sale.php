<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class sale extends Model
{
    use HasFactory;
    protected $table = 'sale'; // 指定資料表名
    public $timestamps = false; // 禁用自動時間戳
    protected $fillable = [
        'bookId',
        'productId',
        'amount',
        'pPrice',
        'pTotalPrice',
        'createTime'
    ];
    public function findBook($bookId)
    {
        $result = DB::table('sale')
            ->join('product', 'sale.productId', '=', 'product.id')
            ->select(
                'sale.amount',
                'sale.pPrice',
                'product.itemName',
            )
            ->where('sale.bookId', $bookId);
        return $result;
    }
    public function saleProduct()
    {

        $result = DB::table('sale')
            ->join('product', 'sale.productId', '=', 'product.id')
            ->select(
                DB::raw('sum(sale.amount) as productAmount'),
                'product.itemName'
            )
            ->groupBy('product.itemName')
            ;

        return $result;
    }
}
