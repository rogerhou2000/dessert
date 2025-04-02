<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class book extends Model
{
    use HasFactory;
    protected $table = 'book'; // 指定資料表名稱
    protected $primaryKey="id";
    public $timestamps = false; // 禁用自動時間戳
    protected $fillable = [
        "id",'userid', 'totalPrice', 'lDiscount', 'bDiscount', 
        'discPrice', 'address', 'createTime'
    ];

    public function bookCount(){
        $result = DB::table('book')
        ->select(DB::raw("
            COUNT(*) AS book
        "))->first()->book;
        return $result;

    }
    public function bookSum(){
        $result = DB::table('book')
        ->select(DB::raw("
            sum(discPrice) AS sum
        "))->first()->sum;
        return $result;
    }
    public function book($userid){
        $result= DB::table('book')->where('userid',$userid);
        return $result;
     }
     public function bookAll(){
         $result = DB::table('book')
        ->join('member', 'book.userid', '=', 'member.id')
        ->select(
            'member.email', 
            'book.*',  
        );
        return $result;
     }
}
