<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\password;

class Member extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="member";
    protected $primaryKey="id";
    protected $fillable=["id","email","name","city","password","address","birthday","level","sumPrice","createdTime"];
    public function checkMember($email)
    {
        return self::where("email", $email)->first();
    }
    public function getUser(){ 
       
        $list = DB::table("member")
        ->selectRaw("id,email,name,city,level")
        ->orderby("id","DESC")
        ->get();
        return $list;
    
    }
    public function memberAge(){
        $result = DB::table('member')
        ->select(DB::raw("
            CASE 
                WHEN FLOOR(DATEDIFF(NOW(), birthday) / 365) < 18 THEN '未成年'
                WHEN FLOOR(DATEDIFF(NOW(), birthday) / 365) >= 30 THEN '30歲及以上'
                ELSE '18至29歲'
            END AS age_group, 
            COUNT(*) AS group_count
        "))
        ->groupBy('age_group');
        return $result;

    }

    public function memberRegion(){
        $result = DB::table('member')
        ->select(DB::raw("
            city, 
            COUNT(*) AS city_count
        "))
        ->groupBy('city');
        return $result;

    }
    public function memberCount(){
        $result = DB::table('member')
        ->select(DB::raw("
            COUNT(*) AS member
        "))->first()->member;
        return $result;

    }


    

}
